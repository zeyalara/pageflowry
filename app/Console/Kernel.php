<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\CheckDeadlineNotifications::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Check deadline notifications every hour
        $schedule->command('notifications:check-deadlines')->hourly();
    }
}
