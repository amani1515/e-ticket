<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\ExportDailyData::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Export daily data at 2 AM every day
        $schedule->command('export:daily-data')
                 ->dailyAt('02:00')
                 ->withoutOverlapping()
                 ->runInBackground();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}