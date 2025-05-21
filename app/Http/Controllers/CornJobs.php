<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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

class CornJobs extends Controller
{
    public function roi_bonus(){ //ROI = Return of Invesment
        $this->process_direct_bonus();

        $income_data = TopUp::where('is_completed',0)
                    ->Where('total_installment_month','>=','month_count')
                    ->whereDate('start_date','!=',date('Y-m-d'))
                    ->get();

        $chunks = $income_data->chunk(15);
        foreach ($chunks as $chunk) {
            RoiJob::dispatch($chunk);
        }
    }

    public function process_direct_bonus(){
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


    public function level_bonus() {
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
    
    public function payout() {
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
