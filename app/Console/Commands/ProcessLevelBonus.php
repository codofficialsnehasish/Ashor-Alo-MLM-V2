<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User; 
use App\Models\BinaryTree; 
use App\Models\TopUp; 
use App\Models\MonthlyReturnMaster;
use App\Models\AccountTransaction;
use App\Models\MlmSetting;
use App\Models\Payout;


use App\Jobs\RoiJob;
use App\Jobs\LevelBonusJob;
use App\Jobs\PayoutJob;

class ProcessLevelBonus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-level-bonus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process Level bonus';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $last_payout_date = Payout::latest('end_date')->first()?->end_date;
        $lastSaturday = Carbon::parse($last_payout_date ?? now());
        // $lastSaturday = Carbon::parse(now());
        $current_day = Carbon::now();
    
        // Process in chunks and dispatch each chunk to a queue job
        $acc_transactions = AccountTransaction::whereDate('created_at', '>=', $lastSaturday)
                                            ->whereDate('created_at', '<=', $current_day)
                                            ->where('which_for', 'ROI Daily')
                                            ->select('user_id', 'created_at') // No need for DB::raw
                                            ->get()
                                            ->groupBy('user_id')
                                            ->map(function ($transactions) {
                                                return $transactions->groupBy(function ($item) {
                                                    return $item->created_at->format('Y-m-d'); // Group by date
                                                })->count(); // Count unique dates per user
                                            });

        $chunks = $acc_transactions->chunk(5);

        foreach ($chunks as $chunk) {
            LevelBonusJob::dispatch($chunk, $lastSaturday, $current_day);
        }
    }
}
