<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class PayoutsProcessing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:payouts-processing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process monthly ROI, level, and payout bonuses on 15th and end of month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $is15th = $today->day === 15;
        $isEndOfMonth = $today->isSameDay($today->copy()->endOfMonth());

        if ($is15th || $isEndOfMonth) {
            $this->info("Processing monthly bonuses for {$today->toDateString()}");

            // Process ROI Bonus
            $this->call('bonus:roi');
            
            // Process Level Bonus
            $this->call('bonus:level');
            
            // Process Payout
            $this->call('bonus:payout');

            $this->info('All monthly bonus processing completed successfully.');
        } else {
            $this->info('Today is neither the 15th nor the end of month. No processing needed.');
        }
    }
}
