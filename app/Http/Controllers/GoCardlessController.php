<?php

namespace App\Http\Controllers;

use App\Models\Members;
use GoCardlessPro\Client;
use GoCardlessPro\Core\Exception\InvalidStateException;
use GoCardlessPro\Environment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class GoCardlessController extends Controller
{
    public $client;

    public function __construct()
    {
        $this->client = new Client(array(
            'access_token' => getenv('GC_ACCESS_TOKEN'),
            'environment' => Environment::SANDBOX
        ));
    }

    /**
     * @throws InvalidStateException
     */
    public function create(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'email|required',
            'amount' => 'required',
            'currency' => 'required',
        ]);

        $billingRequest = $this->client->billingRequests()->create([
            "params" => [
                "mandate_request" => [
                    "currency" => $request->input('currency'),
                ],
            ]
        ]);

        Members::create([
            'name' => $request->input('firstname') . ' ' . $request->input('lastname'),
            'email' => $request->input('email'),
            'customer_id' => $billingRequest->links->customer,
        ]);

        Redis::set($billingRequest->links->customer,
            json_encode(['json' => $billingRequest, 'amount' => $request->input('amount') * 100]),
            'EX',
            86400
        );

        $redirect_url = "http://localhost/gocardless/success?" .
            "amount=" . $request->input('amount') .
            '&name=' . $request->input('firstname') . '_' . $request->input('lastname') .
            '&id=' . $billingRequest->id .
            '&currency=' . $request->input('currency');

        $flow = $this->client->billingRequestFlows()->create([
            "params" => [
                "redirect_uri" => $redirect_url,
                "exit_uri" => "http://localhost/error",
                "links" => [
                    "billing_request" => $billingRequest->id
                ],
                "prefilled_customer" => [
                    "given_name" => $request->input('firstname'),
                    "family_name" => $request->input('lastname'),
                    "email" => $request->input('email'),
                ],
                "lock_currency" => true,
            ]
        ]);

        return response()->json([
            'link' => $flow->authorisation_url,
            'name' => $request->input('firstname') . ' ' . $request->input('lastname')
        ]);
    }

    public function update($id)
    {
        $member = Members::where('id', $id)->first();

        $subscription = $this->client->subscriptions()->list([
            "params" => ["customer" => $member->customer_id]
        ]);

        $this->client->subscriptions()->cancel($subscription->api_response->body->subscriptions[0]->id);

        return Inertia::render('RequestSent');
    }

    public function success(Request $request)
    {
        return Inertia::render('GoCardlessSuccess', [
            'data' => [
                'customer' => $request->query('name'),
                'amount' => $request->query('amount'),
                'paymentId' => $request->query('id'),
                'currency' => $request->query('currency'),
                'status' => 'processing',
            ],
        ]);
    }
}
