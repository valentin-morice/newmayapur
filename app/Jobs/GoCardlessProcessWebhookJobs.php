<?php

namespace App\Jobs;

use App\Models\BillingRequest;
use App\Models\Members;
use App\Models\ProcessedWebhooks;
use App\Models\Subscriptions;
use GoCardlessPro\Client;
use GoCardlessPro\Environment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class GoCardlessProcessWebhookJobs extends SpatieProcessWebhookJob
{

    public $client;

    public function handle()
    {
        if (ProcessedWebhooks::where('webhook_id', $this->webhookCall->payload['meta']['webhook_id'])->exists()) {
            return;
        }

        $this->client = new Client(array(
            'access_token' => getenv('GC_ACCESS_TOKEN'),
            'environment' => Environment::SANDBOX
        ));

        $events = $this->webhookCall->payload['events'];

        foreach ($events as $event) {
            switch ($event['resource_type']) {
                case "billing_requests":
                    $this->process_billing_request_event($event);
                    break;
                case "subscriptions":
                    $this->process_subscriptions_events($event);
            }
        }

        ProcessedWebhooks::create([
            'webhook_id' => $this->webhookCall->payload['meta']['webhook_id']
        ]);
    }

    public function process_billing_request_event($event)
    {
        switch ($event['action']) {
            case 'fulfilled':

                $request = BillingRequest::where('gocardless_id', $event['links']['billing_request'])->first();

                $mandate = $this->client->mandates()->list([
                    "params" => ["customer" => $event['links']['customer']
                    ]]);

                $this->client->subscriptions()->create([
                    "params" => [
                        "amount" => $request->amount * 100,
                        "currency" => $request->currency,
                        "name" => "Membership",
                        "interval_unit" => "monthly",
                        "day_of_month" => 1,
                        "links" => ["mandate" => $mandate->records[0]->id]]
                ]);
                break;
            default:
                Log::info('A billing_request webhook has been received.');
                break;
        }
    }

    public function process_subscriptions_events($event)
    {
        switch ($event['action']) {

            case 'created':

                $subscription = $this->client->subscriptions()->get($event['links']['subscription']);
                $mandate_id = $subscription->links->mandate;
                $customer_id = $this->client->mandates()->get($mandate_id)->links->customer;
                $customer = $this->client->customers()->get($customer_id);

                $member = Members::create([
                    'name' => $customer->given_name . ' ' . $customer->family_name,
                    'email' => $customer->email,
                    'customer_id' => $customer->id,
                    'city' => $customer->city,
                    'address' => $customer->address_line1 . ' ' . $customer->address_line2,
                    'country' => $customer->country_code,
                    'state' => $customer->region,
                    'postal_code' => $customer->postal_code,
                ]);

                Subscriptions::create([
                    'members_id' => $member->id,
                    'amount' => $subscription->amount / 100,
                    'currency' => $subscription->currency,
                    'status' => $subscription->status,
                    'payment_method' => 'gocardless',
                ]);

                break;

            case 'cancelled':

                $subscription = $this->client->subscriptions()->get($event['links']['subscription']);

                $mandate_id = $subscription->links->mandate;

                $member = Members::where('customer_id', $this->client->mandates()->get($mandate_id)->links->customer,)->first();

                $member->subscriptions()->first()->update([
                    'status' => $subscription->status,
                ]);

                break;
            default:
                Log::info('A subscriptions webhook has been received.');
                break;
        }
    }
}

