<?php

namespace App\Services\Subscriptions;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Services\Subscriptions\Models\Subscription;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Services\Payments\Events\PaymentCancelledEvent;
use App\Services\Payments\Events\PaymentCompletedEvent;
use App\Services\Subscriptions\Listeners\CancelSubscriptionListener;
use App\Services\Subscriptions\Listeners\CompleteSubscriptionListener;

class SubscriptionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'subscription' => Subscription::class,
        ]);

        Event::listen(PaymentCompletedEvent::class, CompleteSubscriptionListener::class);
        Event::listen(PaymentCancelledEvent::class, CancelSubscriptionListener::class);

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        }
    }
}
