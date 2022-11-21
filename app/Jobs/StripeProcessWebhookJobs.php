<?php

namespace App\Jobs;

use App\Models\Members;
use App\Models\Payments;
use App\Models\ProcessedWebhooks;
use App\Models\Subscriptions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;

class StripeProcessWebhookJobs extends SpatieProcessWebhookJob
{

    public function handle()
    {
        if (ProcessedWebhooks::where('webhook_id', $this->webhookCall->payload['id'])->exists()) {
            return;
        }

        $event_type = $this->webhookCall->payload['type'];

        if (str_contains($event_type, 'subscription')) {
            $this->process_subscription($event_type);
        } else if (str_contains($event_type, 'payment_intent')) {
            $this->process_payment_intent();
        }

        ProcessedWebhooks::create([
            'webhook_id' => $this->webhookCall->payload['id']
        ]);
    }

    private function process_payment_intent()
    {
        $client = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

        $customer = $client->customers->retrieve($this->webhookCall->payload['data']['object']['customer'], []);

        $payment = Payments::where('payment_id', $this->webhookCall->payload['data']['object']['id'])->exists();

        if ($payment) {
            Payments::where('payment_id', $this->webhookCall->payload['data']['object']['id'])->first()->update([
                'status' => $this->webhookCall->payload['data']['object']['status']
            ]);

            return;
        }

        Payments::create([
            'name' => $customer->name,
            'amount' => $this->webhookCall->payload['data']['object']['amount'] / 100,
            'payment_id' => $this->webhookCall->payload['data']['object']['id'],
            'email' => $customer->email,
            'status' => $this->webhookCall->payload['data']['object']['status'],
            'currency' => strtoupper($this->webhookCall->payload['data']['object']['currency'])
        ]);
    }

    public function process_subscription($event_type)
    {

        $customer_id = $this->webhookCall->payload['data']['object']['customer'];
        $member = Members::where('customer_id', $customer_id)->first();

        switch ($event_type) {
            case 'customer.subscription.created':
                $subscription = Subscriptions::create([
                    'members_id' => $member->id,
                    'amount' => $this->webhookCall->payload['data']['object']['plan']['amount'] / 100,
                    'currency' => strtoupper($this->webhookCall->payload['data']['object']['plan']['currency']),
                    'status' => $this->webhookCall->payload['data']['object']['status'],
                    'payment_method' => 'stripe',
                ]);
                break;
            case 'customer.subscription.updated':
                $member->subscriptions->first->update([
                    'status' => $this->webhookCall->payload['data']['object']['status'],
                ]);
                break;
            case 'customer.subscription.deleted':
                $member->subscriptions->first->update([
                    'status' => 'cancelled',
                ]);
                break;
            default:
                Log::info('A subscriptions webhook has been received.');
        }
    }
}
