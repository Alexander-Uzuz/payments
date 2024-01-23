<?php

namespace App\Services\Orders;

use App\Services\Orders\Models\Order;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
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
            'order' => Order::class,
        ]);

        if($this->app->runningInConsole()){
            $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        }
    }
}
