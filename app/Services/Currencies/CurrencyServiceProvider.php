<?php

namespace App\Services\Currencies;

use Illuminate\Support\ServiceProvider;
use App\Services\Currencies\Commands\InstallCurrenciesCommand;
use App\Services\Currencies\Commands\UpdateCurrencyPricesCommand;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/Migrations');

            $this->commands([
                InstallCurrenciesCommand::class,
                UpdateCurrencyPricesCommand::class,
            ]);
        }
    }
}
