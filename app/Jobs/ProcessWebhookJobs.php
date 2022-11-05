<?php

namespace App\Jobs;

use GoCardlessPro\Client;
use GoCardlessPro\Environment;
use Illuminate\Support\Facades\Redis;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWebhookJobs extends SpatieProcessWebhookJob
{
    public function handle()
    {
        $client = new Client(array(
            'access_token' => getenv('GC_ACCESS_TOKEN'),
            'environment' => Environment::SANDBOX
        ));

        $keys = Redis::keys('*');
        $billingRequests = [];
        foreach ($keys as $key) {
            $billingRequests[] = json_decode(Redis::get($key));
        }

        $events = $this->webhookCall->payload['events'];
        $event = null;

        // Finding relevant webhook event
        for ($i = 0; $i < count($events); $i++) {
            if (isset($events[$i]['details']['cause'])) {
                if ($events[$i]['details']['cause'] === 'billing_request_fulfilled') {
                    $event = $events[$i];
                }
            }
        }


        if (isset($event)) {
            if ($event['details']['cause'] === 'billing_request_fulfilled') {

                $request = null;

                // Find matching billing request
                foreach ($billingRequests as $billingRequest) {
                    if ($billingRequest->json->api_response->body->billing_requests->id === $event['links']['billing_request']) {
                        $request = $billingRequest;
                    }
                }

                $mandate = $client->mandates()->list([
                    "params" => ["customer" => $event['links']['customer']
                    ]]);

                $client->subscriptions()->create([
                    "params" => [
                        "amount" => $request->amount,
                        "currency" => $request->json->api_response->body->billing_requests->mandate_request->currency,
                        "name" => "Membership",
                        "interval_unit" => "monthly",
                        "day_of_month" => 1,
                        "links" => ["mandate" => $mandate->records[0]->id]]
                ]);
            }
        }
    }
}

