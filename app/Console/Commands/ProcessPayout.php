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
use Carbon\Carbon;

use App\Jobs\RoiJob;
use App\Jobs\LevelBonusJob;
use App\Jobs\PayoutJob;

class ProcessPayout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-payout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process Payout';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $last_payout_date = Payout::latest('end_date')->first()?->end_date;
        $lastSaturday = Carbon::parse($last_payout_date ?? now());
        // $lastSaturday = Carbon::parse(now());
        $current_day = Carbon::now();

        $transactions = BinaryTree::where('status',1)->pluck('user_id');

        $chunks = $transactions->chunk(5);
        foreach ($chunks as $chunk) {
            PayoutJob::dispatch($chunk, $lastSaturday, $current_day);
        }
    }
}
