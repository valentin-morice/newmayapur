<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Models\Payments;
use App\Models\Subscriptions;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;


class AdminController extends Controller
{
    public $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.apilayer.com',
            'timeout' => 100,
            'headers' => ['apikey' => getenv('API_CURRENCY_CONVERTOR')]
        ]);
    }

    public function index(Request $request)
    {
        return Inertia::render('AdminMembers', [
            'members' => Members::query()
                ->has('subscriptions')
                ->when($request->input(['search']), function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(12)
                ->withQueryString()
                ->through(fn($member) => [
                    'id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                    'date' => Carbon::parse($member->created_at)->format('d/m/Y'),
                    'amount' => $member->subscriptions->first()->amount,
                    'currency' => strtoupper($member->subscriptions->first()->currency),
                    'status' => ucwords(str_replace('_', ' ', $member->subscriptions->first()->status)),
                ]),
            'query' => $request->input(['search'])
        ]);
    }

    public function index_payments(Request $request)
    {
        return Inertia::render('AdminPayments', [
            'payments' => Payments::query()
                ->when($request->input(['search']), function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(12)
                ->withQueryString()
                ->through(fn($payment) => [
                    'id' => $payment->id,
                    'name' => $payment->name,
                    'email' => $payment->email,
                    'date' => Carbon::parse($payment->created_at)->format('d/m/Y'),
                    'amount' => $payment->amount,
                    'currency' => $payment->currency,
                    'status' => ucwords(str_replace('_', ' ', $payment->status)),
                ]),
            'query' => $request->input(['search'])
        ]);
    }

    public function show($id)
    {
        $member = Members::where('id', $id)->first();

        function get_url($method)
        {
            if ($method === 'stripe') {
                return getenv('STRIPE_URL');
            } else if ($method === 'gocardless') {
                return getenv('GC_URL');
            } else if ($method === 'wise') {
                return 'https://wise.com/';
            } else if ($method === 'banque_postale') {
                return 'https://www.labanquepostale.fr/associations.html';
            } else if ($method === 'paypal') {
                return getenv('PAYPAL_URL');
            }
        }

        return Inertia::render('AdminShow', [
            'member' => [
                'id' => $id,
                'name' => $member->name,
                'email' => $member->email,
                'customer_id' => $member->customer_id,
                'address' => [
                    'city' => $member->city,
                    'country' => $member->country,
                    'street' => $member->address,
                    'state' => $member->state,
                    'postal_code' => $member->postal_code
                ],
                'subscription' => [
                    'amount' => $member->subscriptions->first()->amount,
                    'currency' => $member->subscriptions->first()->currency,
                    'status' => ucwords(str_replace('_', ' ', $member->subscriptions->first()->status)),
                    'date' => Carbon::parse($member->created_at)->format('d/m/Y'),
                    'payment_method' => ucwords(str_replace('_', ' ', $member->subscriptions->first()->payment_method)),
                ],
            ],
            'url' => get_url($member->subscriptions->first()->payment_method),
        ]);
    }

    public function overview()
    {

        $new_cancels = $this->new_movements('cancelled');

        $new_subscriptions = $this->new_movements('active');

        $new_members = $this->filter($new_subscriptions);

        $new_cancels_members = $this->filter($new_cancels);

        Cache::put('sub_total', $this->subscriptions()['total'], 43200);

        return Inertia::render('AdminOverview', [
            'new_members' => $new_members,
            'new_cancels' => $new_cancels_members,
            'percentage' => [
                'value' => $this->percentage(Subscriptions::where('status', 'active')->get()->toArray(), Subscriptions::where('status', 'cancelled')->get()->toArray())
            ],
            'members' => [
                'total_active' => Members::whereHas('subscriptions', function ($query) {
                    $query->where('status', 'active');
                })->count(),
                'total_cancelled' => Members::whereHas('subscriptions', function ($query) {
                    $query->where('status', 'cancelled');
                })->count()
            ],
            'members_loc' => $this->memberByLoc(),
            'subscriptions' => [
                'total' => Cache::get('sub_total'),
                'all' => $this->subscriptions()['all'],
            ]
        ]);
    }

    private function percentage($active, $cancelled)
    {
        $x = count($cancelled);
        $y = count($active);

        return ($y / ($x + $y)) * 100;
    }

    private function filter($array)
    {
        $results = [];

        foreach ($array as $item) {
            $results[] = [
                'member' => [
                    'name' => $item->members->name,
                    'date' => Carbon::parse($item->members->created_at)->format('d/m/Y'),
                    'id' => $item->members->id
                ], 'subscription' => [
                    'amount' => $item->amount,
                    'currency' => $item->currency
                ],
            ];
        }

        return $results;
    }

    private function new_movements($status)
    {
        return Subscriptions::where('status', $status)
            ->take(5)
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    private function memberByLoc()
    {
        $groups = \App\Models\Members::has('subscriptions')->get()->mapToGroups(function ($item, $key) {
            return [$item['country'] => $item];
        })->toArray();

        $arr = [];

        for ($i = 0; $i < count($groups); $i++) {
            $arr[] = [array_keys($groups)[$i] => count($groups[array_keys($groups)[$i]])];
        }

        return $arr;
    }

    private function subscriptions()
    {
        $groups = \App\Models\Subscriptions::where('status', 'active')->get()->mapToGroups(function ($item, $key) {
            return [$item['currency'] => $item['amount']];
        })->toArray();

        $arr = [];

        for ($i = 0; $i < count($groups); $i++) {
            $arr[] = [array_keys($groups)[$i] => array_sum($groups[array_keys($groups)[$i]])];
        }

        $converted = [];

        foreach ($arr as $value) {
            $number = json_decode($this->client->get('/exchangerates_data/convert?to=eur&from=' . key($value) . '&amount=' . $value[key($value)])->getBody()->getContents(), true)['result'];
            $converted[] = number_format((float)$number, 2, '.', ',');
        }

        return [
            'total' => array_sum($converted) + \App\Models\Subscriptions::where('status', 'active')->where('currency', 'EUR')->sum('amount'),
            'all' => $arr
        ];
    }
}
