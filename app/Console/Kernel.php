<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Run ROI bonus daily at a specific time (e.g., 11:40 PM)
        $schedule->command('app:process-roi-bonus')
                ->dailyAt('23:40')
                ->timezone('Asia/Kolkata');
        
        // Level bonus (keep your existing schedule)
        $schedule->command('app:process-level-bonus')
                // ->monthlyOn(15, '23:45')
                ->monthlyOn(06, '18:28')
                ->lastDayOfMonth('23:45')->timezone('Asia/Kolkata');
        
        // Payout (keep your existing schedule)
        $schedule->command('app:process-payout')
                ->monthlyOn(15, '23:50')
                ->lastDayOfMonth('23:50')->timezone('Asia/Kolkata');
    }
}