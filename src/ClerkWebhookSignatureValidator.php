<?php

namespace CLDT\Clerk;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;
use Svix\Exception\WebhookVerificationException;

class ClerkWebhookSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        if (! config('clerk.verify_signature')) {
            return true;
        }

        $payload = $request->getPayload();
        $header = array(
            'webhook-id'  => $request->header('webhook-id'),
            'webhook-timestamp' => $request->header('webhook-timestamp'),
            'webhook-signature' => $request->header('webhook-signature'),
        );

        $wh = new \Svix\Webhook(config('clerk.webhook_token'));
        try {
            $wh->verify($payload, $header);
            return true;
        } catch (WebhookVerificationException $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}