<?php

namespace App\Providers;

use App\Policies\NotificationPolicy;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        VerifyCsrfToken::except(['/logout', '/realtor/listing/*']);
        Gate::policy(DatabaseNotification::class, NotificationPolicy::class);
    }
}
