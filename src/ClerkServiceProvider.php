<?php

namespace CLDT\Clerk;

use CLDT\Clerk\Http\Controllers\ClerkWebhooksController;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ClerkServiceProvider extends PackageServiceProvider
{
    public function registeringPackage()
    {
        $this->app->bind('clerk', function () {
            return new Clerk();
        });

        parent::registeringPackage();
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('clerk')
            ->hasConfigFile()
            ->hasMigration('create_clerk_webhook_calls_table');
    }

    public function bootingPackage()
    {
        $webhookPath = config('clerk.webhook_path');

        Route::post($webhookPath, ClerkWebhooksController::class);
    }
}
