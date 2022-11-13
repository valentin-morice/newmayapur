<?php

namespace App\Jobs;

use App\Models\Members;
use App\Models\Subscriptions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class StripeProcessWebhookJobs extends SpatieProcessWebhookJob
{
    public function handle()
    {
        $webhook = Redis::exists($this->webhookCall->payload['id']);

        if ($webhook) return;

        $event_type = $this->webhookCall->payload['type'];
        $this->process_subscription($event_type);

        Redis::set($this->webhookCall->payload['id'], '');
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
