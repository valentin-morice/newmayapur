<?php

namespace App\Http\Controllers;

use App\Models\BillingRequest;
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
            'member.firstname' => 'required',
            'member.lastname' => 'required',
            'member.email' => 'email|required',
            'member.subscription.amount' => 'required',
            'member.subscription.currency' => 'required',
        ]);

        $name = $request->input('member.firstname') . ' ' . $request->input('member.lastname');
        $email = $request->input('member.email');
        $amount = $request->input('member.subscription.amount');
        $currency = $request->input('member.subscription.currency.currency');

        $billingRequest = $this->client->billingRequests()->create([
            "params" => [
                "mandate_request" => [
                    "currency" => $currency,
                ],
            ]
        ]);

        BillingRequest::create([
            'gocardless_id' => $billingRequest->id,
            'amount' => $amount,
            'currency' => strtoupper($currency),
        ]);


        $redirect_url = url('/gocardless/success?') .
            "amount=" . $amount .
            '&name=' . $name .
            '&id=' . $billingRequest->id .
            '&currency=' . $currency;

        $flow = $this->client->billingRequestFlows()->create([
            "params" => [
                "redirect_uri" => $redirect_url,
                "exit_uri" => url('/gocardless/error'),
                "links" => [
                    "billing_request" => $billingRequest->id
                ],
                "prefilled_customer" => [
                    "given_name" => $request->input('member.firstname'),
                    "family_name" => $request->input('member.lastname'),
                    "email" => $request->input('member.email'),
                ],
                "lock_currency" => true,
            ]
        ]);

        return response()->json([
            'link' => $flow->authorisation_url,
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
