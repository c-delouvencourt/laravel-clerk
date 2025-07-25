<?php

/*
 * Clerk API Configuration
 * https://clerk.com/docs
 */
return [
    // API
    // ----------------------------------------------------------

    // The API endpoint
    'endpoint' => env('CLERK_ENDPOINT', 'https://api.clerk.com/v1'),

    // The API ID and Token
    'api_key' => env('CLERK_API_SECRET', ''),

    // Webhook API
    // https://clerk.com/docs/webhooks/overview
    // ----------------------------------------------------------

    /*
     * You can define the job that should be run when a certain webhook hits your application
     * here.
     *
     * You can find a list of Clerk webhook in your app settings
     *
     * You can use "*" to let a job handle all sent webhook types
     */
    'webhook_jobs' => [
        // 'user.created' => \App\Jobs\Clerk\HandleClerkUserCreatedJob::class,
        // '*' => \App\Jobs\Clerk\HandleAllWebhooks::class
    ],

    /*
     * This model will be used to store all incoming webhooks.
     * It should be or extend `Spatie\GitHubWebhooks\Models\GitHubWebhookCall`
     */
    'webhook_model' => \CLDT\Clerk\Models\ClerkWebhookCall::class,

    // The path where the webhook will be accessible
    'webhook_path' => env('CLERK_WEBHOOK_PATH', '/webhook/clerk'),

    // The path where the webhook will be accessible
    'webhook_table_name' => env('CLERK_WEBHOOK_TABLE_NAME', 'webhook_clerk_calls'),

    // If you want to verify the webhook token sent by Clerk
    'webhook_verify_token' => env('CLERK_WEBHOOK_VERIFY_TOKEN', true),

    // The token to verify the webhook
    'webhook_token' => env('CLERK_WEBHOOK_TOKEN', ''),

    // Prune the webhook calls after X days to keep the database clean
    'webhook_prune_calls_after_days' => env('CLERK_WEBHOOK_PRUNE_CALLS_AFTER_DAYS', 30),
];