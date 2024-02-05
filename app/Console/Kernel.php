<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Services\Currencies\Sources\SourceEnum;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Services\Currencies\Commands\UpdateCurrencyPricesCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command(UpdateCurrencyPricesCommand::class, [SourceEnum::cbrf->value])->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
