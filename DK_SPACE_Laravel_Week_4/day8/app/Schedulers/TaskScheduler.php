<?php

namespace App\Schedulers;

use Illuminate\Console\Scheduling\Schedule;

class TaskScheduler
{
    public function __invoke(Schedule $schedule): void
    {
        $schedule->command('report:summary')->dailyAt('01:00');
        $schedule->command('backup:database')->weekly();
    }
}
