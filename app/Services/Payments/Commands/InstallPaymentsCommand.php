<?php

namespace App\Services\Payments\Commands;

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
            ], [
                'name' => 'Тестовый способ',
                'active' => !app()->isProduction(),
            ]);

        PaymentMethod::query()
            ->firstOrCreate([
                'driver' => PaymentDriverEnum::tinkoff,
            ], [
                'name' => 'Тинькофф',
                'active' => false,
            ]);
    }
}
