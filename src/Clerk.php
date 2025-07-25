<?php

namespace CLDT\Clerk;

use CLDT\Clerk\Api\Call;
use CLDT\Clerk\Api\Company;
use CLDT\Clerk\Api\Contact;
use CLDT\Clerk\Api\ConversationIntelligence;
use CLDT\Clerk\Api\DialerCampaign;
use CLDT\Clerk\Api\Integration;
use CLDT\Clerk\Api\Message;
use CLDT\Clerk\Api\Number;
use CLDT\Clerk\Api\Tag;
use CLDT\Clerk\Api\Team;
use CLDT\Clerk\Api\User;
use CLDT\Clerk\Api\Webhook;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Clerk
{
    protected PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('clerk.api_key'),
        ])->baseUrl(config('clerk.endpoint'));
    }

    public static function build()
    {
        return new static();
    }

    public function user(): User
    {
        return new User($this->client);
    }
}
