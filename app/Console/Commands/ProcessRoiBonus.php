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

class ProcessRoiBonus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-roi-bonus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process ROI bonus';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->process_direct_bonus();

        $income_data = TopUp::where('is_completed', 0)
            ->where('total_installment_month', '>=', 'month_count')
            ->whereDate('start_date', '!=', date('Y-m-d'))
            ->get();

        $chunks = $income_data->chunk(15);
        foreach ($chunks as $chunk) {
            RoiJob::dispatch($chunk);
        }

        $this->info('ROI bonus processing dispatched successfully.');
    }

    protected function process_direct_bonus()
    {
        $today_join_users = TopUp::whereDate('created_at',date('Y-m-d'))->where('is_provide_direct',1)->get();

        foreach($today_join_users as $join_data){
            
            $member = User::find($join_data->user_id);
            // return $member;
            if($member->sponsor){
                $agent = $member->sponsor;
                if(!AccountTransaction::where('user_id',$agent->user_id)->where('which_for','Direct Bonus')->whereDate('created_at',date('Y-m-d'))->where('topup_id',$join_data->id)->exists()){
                    if($agent->status == 1){
                        
                        //Direct Bonus
                        $mlm_settings = MlmSetting::first();
                        $user_bonus = ($join_data->total_amount * ($mlm_settings->agent_direct_bonus/100));

                        $transaction = AccountTransaction::create([
                            'user_id' => $agent->user_id,
                            'amount' => $user_bonus,
                            'which_for' => 'Direct Bonus',
                            'status' => 1,
                            'generated_against_user_id' => $member->id,
                            'topup_id' => $join_data->id,
                        ]);
                    }
                }
            }
        }
    }
}
