<?php

namespace App\Http\Controllers;

use GoCardlessPro\Client;
use GoCardlessPro\Core\Exception\InvalidStateException;
use GoCardlessPro\Environment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GoCardlessPro\Webhook;
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
            json_encode(['json' => $billingRequest, 'amount' => $request->input('amount') * 100])
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

    public function handle(Request $request)
    {
        $webhook_endpoint_secret = getenv("WEBHOOK_ENDPOINT_SECRET");

        $request_body = file_get_contents('php://input');

        $signature_header = $request->header('Webhook-Signature');

        try {

            $data = json_decode($request->getContent());

            $confirmedMandate = null;

            foreach ($data->events as $event) {
                if ($event->details->cause === 'mandate_created') {
                    $confirmedMandate = $event;
                }
            }

            if (!$confirmedMandate) return response('ok', 200);

            $client = new Client(array(
                'access_token' => getenv('GC_ACCESS_TOKEN'),
                'environment' => Environment::SANDBOX
            ));

            $mandate = $client->mandates()->list([
                "params" => ["customer" => \Session::get('GC_customer_id')]
            ]);

            if ($confirmedMandate->links->mandate === $mandate->records[0]->id) {

                Log::info(\Session::get('GC_customer_amount'));
                Log::info(\Session::get('GC_customer_currency'));

                $client->subscriptions()->create([
                    "params" => [
                        "amount" => \Session::get('GC_customer_amount'),
                        "currency" => \Session::get('GC_customer_currency'),
                        "name" => "Membership",
                        "interval_unit" => "monthly",
                        "day_of_month" => 1,
                        "links" => ["mandate" => $mandate->records[0]->id]]
                ]);
            }
        } catch (\GoCardlessPro\Core\Exception\InvalidSignatureException $e) {
            header("HTTP/1.1 498 Invalid Token");
        }
    }
}
