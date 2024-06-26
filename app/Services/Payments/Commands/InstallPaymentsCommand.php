<?php

namespace App\Services\Payments\Commands;

use App\Services\Currencies\Models\Currency;
use App\Services\Payments\Enums\PaymentDriverEnum;
use App\Services\Payments\Models\PaymentMethod;
use Illuminate\Console\Command;

class InstallPaymentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->warn('Создание платежа');

        $this->installPaymentsMethod();

        $this->info('Платёж создан');
    }

    private function installPaymentsMethod(): void
    {
        PaymentMethod::query()
            ->firstOrCreate([
                'driver' => PaymentDriverEnum::test,
                'driver_currency_id' => 'RUB',
            ], [
                'name' => 'Тестовый способ',
                'active' => !app()->isProduction(),
            ]);

        PaymentMethod::query()
            ->firstOrCreate([
                'driver' => PaymentDriverEnum::test,
                'driver_currency_id' => 'USD',
            ], [
                'name' => 'Тестовый способ',
                'active' => !app()->isProduction(),
            ]);

        PaymentMethod::query()
            ->firstOrCreate([
                'driver' => PaymentDriverEnum::tinkoff,
                'driver_currency_id' => 'RUB',
            ], [
                'name' => 'Тинькофф',
                'active' => false,
            ]);

        PaymentMethod::query()
            ->firstOrCreate([
                'driver' => PaymentDriverEnum::stripe_elements,
                'driver_currency_id' => Currency::USD,
            ], [
                'name' => 'Stripe Elements',
                'active' => false,
            ]);
    }
}
