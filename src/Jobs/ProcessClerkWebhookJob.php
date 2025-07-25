<?php

namespace CLDT\Clerk\Jobs;


use function collect;
use function dispatch;
use function event;

use CLDT\Clerk\Exceptions\JobClassDoesNotExist;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;
use CLDT\Clerk\Models\ClerkWebhookCall;

class ProcessClerkWebhookJob extends ProcessWebhookJob
{
    public ClerkWebhookCall | WebhookCall $webhookCall;

    public function handle()
    {
        event("clerk::{$this->webhookCall->eventName()}", $this->webhookCall);

        collect(config('clerk.webhook_jobs'))
            ->filter(function (string $jobClassName, $eventActionName) {
                if ($eventActionName === '*') {
                    return true;
                }

                return in_array($eventActionName, [
                    $this->webhookCall->eventName(),
                ]);
            })
            ->each(function (string $jobClassName) {
                if (! class_exists($jobClassName)) {
                    throw JobClassDoesNotExist::make($jobClassName);
                }
            })
            ->each(fn (string $jobClassName) => dispatch(new $jobClassName($this->webhookCall)));
    }
}