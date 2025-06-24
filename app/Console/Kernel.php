<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            app('App\Http\Controllers\VehiculeController')->checkVehicleNotifications();
        })->daily(); //   // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        \App\Console\Commands\DownloadLucide::class;
        $this->load(__DIR__.'/Commands');
        \App\Console\Commands\DownloadAssets::class;
        require base_path('routes/console.php');


    }
}
