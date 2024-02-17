<?php

namespace App\Providers;

use App\Adapters\CurrencyPaymentConverter;
use App\Services\Payments\Contracts\PaymentConverter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentConverter::class, CurrencyPaymentConverter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        bcscale(2);
    }
}
