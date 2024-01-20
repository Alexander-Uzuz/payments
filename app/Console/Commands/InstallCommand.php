<?php

namespace App\Console\Commands;

use App\Services\Currencies\Commands\InstallCurrenciesCommand;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'install';

    public function handle()
    {
        $this->warn('Установка приложения ...');

        $this->call(InstallCurrenciesCommand::class);

        $this->info('Приложение установленно');
    }
}
