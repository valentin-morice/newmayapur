<?php

namespace App\Jobs;

use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class StripeProcessWebhookJobs extends SpatieProcessWebhookJob
{
    public function handle()
    {
        return response(200);
    }
}
