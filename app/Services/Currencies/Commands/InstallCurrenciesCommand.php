<?php

namespace App\Services\Currencies\Commands;

use Illuminate\Console\Command;
use App\Support\Values\AmountValue;
use App\Services\Currencies\Models\Currency;
use App\Services\Currencies\Sources\SourceEnum;

class InstallCurrenciesCommand extends Command
{
    protected $signature = 'currencies:install';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->warn('Установка валют');

        $this->installCurrencies();

        $this->info('Валюты установленны');
    }

    private function installCurrencies()
    {
        Currency::query()
            ->firstOrCreate([
                'id' => 'RUB',
            ], [
                'name' => 'Рубль',
                'price' => new AmountValue(1),
                'source' => SourceEnum::manual,
            ]);

        Currency::query()
            ->firstOrCreate([
                'id' => Currency::USD,
            ], [
                'name' => 'Доллар',
                'price' => new AmountValue(100),
                'source' => SourceEnum::cbrf,
            ]);

        Currency::query()
            ->firstOrCreate([
                'id' => Currency::EUR,
            ], [
                'name' => 'Евро',
                'price' => new AmountValue(100),
                'source' => SourceEnum::cbrf,
            ]);
    }
}
