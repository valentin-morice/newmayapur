<?php

namespace App\Http\Controllers;

use GoCardlessPro\Client;
use GoCardlessPro\Core\Exception\InvalidStateException;
use GoCardlessPro\Environment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

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

        Redis::set($billingRequest->links->customer,
            json_encode(['json' => $billingRequest, 'amount' => $request->input('amount') * 100]),
            'EX',
            86400
        );

        $flow = $this->client->billingRequestFlows()->create([
            "params" => [
                "redirect_uri" => "http://localhost",
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
}
