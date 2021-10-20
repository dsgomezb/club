<?php

namespace App\Console;

use App\Jobs\CreatePayments;
use App\Jobs\SendPaymentButton;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new CreatePayments)->dailyAt('0:10');
        $schedule->job(new SendPaymentButton)->dailyAt('1:00');
        $schedule->job(new SendPaymentWarning)->dailyAt('2:00');
        $schedule->job(new BanDefaultersAndNotify)->dailyAt('3:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
