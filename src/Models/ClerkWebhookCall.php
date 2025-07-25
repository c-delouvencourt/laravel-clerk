<?php

namespace CLDT\Clerk\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Support\Arr;
use Spatie\WebhookClient\Models\WebhookCall;

class ClerkWebhookCall extends WebhookCall
{
    use MassPrunable;

    public function getTable(): string
    {
        return config(config('clerk.webhook_table_name'), parent::getTable());
    }

    public function eventName(): string
    {
        return $this->payload('event') ?? 'unknown';
    }

    public function payload(string $key = null): mixed
    {
        if (! is_null($key)) {
            return Arr::get($this->payload, $key);
        }

        return $this->payload;
    }

    public function prunable(): Builder
    {
        $pruneAfterDays = config('clerk.webhook_prune_calls_after_days');

        return static::query()->where('created_at', '<=', now()->subDays($pruneAfterDays));
    }
}