<?php

namespace CLDT\Clerk\Http\Controllers;

use CLDT\Clerk\ClerkWebhookSignatureValidator;
use CLDT\Clerk\Jobs\ProcessClerkWebhookJob;
use Illuminate\Http\Request;
use Spatie\WebhookClient\Exceptions\InvalidConfig;
use Spatie\WebhookClient\Exceptions\InvalidWebhookSignature;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookProcessor;
use Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile;
use Symfony\Component\HttpFoundation\Response;

class ClerkWebhooksController
{
    /**
     * @throws InvalidConfig
     */
    public function __invoke(Request $request)
    {
        $webhookConfig = new WebhookConfig([
            'name' => 'Clerk',
            'signing_secret' => config('clerk.webhook_token'),
            'signature_header_name' => '',
            'signature_validator' => ClerkWebhookSignatureValidator::class,
            'webhook_profile' => ProcessEverythingWebhookProfile::class,
            'webhook_model' => config('clerk.webhook_model'),
            'process_webhook_job' => ProcessClerkWebhookJob::class,
            'store_headers' => [],
        ]);

        try {
            (new WebhookProcessor($request, $webhookConfig))->process();
        } catch (InvalidWebhookSignature $ex) {
            return response()->json(['message' => 'invalid signature'], Response::HTTP_FORBIDDEN);
        }

        return response()->json(['message' => 'ok']);
    }
}