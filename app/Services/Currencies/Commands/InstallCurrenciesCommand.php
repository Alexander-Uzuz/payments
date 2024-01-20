<?php

namespace App\Services\Currencies\Commands;

use App\Services\Currencies\Models\Currency;
use Illuminate\Console\Command;

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
        ],[
            'name' => 'Рубль',
        ]);
    }
}
