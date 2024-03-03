<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Definir los comandos de la aplicación.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call('App\Http\Controllers\EmailqueueController@checkEmails')->everyMinute();
    }

    /**
     * Comandos para la aplicación.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
