<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\TopUp;
use App\Models\BinaryTree;
use App\Models\AccountTransaction;
use App\Services\LevelBonusService;
use Illuminate\Bus\Queueable;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class LevelBonusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transactions;
    protected $levelBonusService;
    protected $start_date;
    protected $end_date;


    /**
     * Create a new job instance.
     *
     * @param $transactions
     * @param LevelBonusService $levelBonusService
     */
    public function __construct($transactions, $start_date, $end_date) //, $end_date
    {
        $this->transactions = $transactions;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->levelBonusService = app(LevelBonusService::class); // Using Laravel's service container to resolve the service
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->transactions as $key => $value) {

            // $income_data = TopUp::where('user_id',$key)->where('is_provide_level',1)->get();
            $income_data = TopUp::where('user_id',$key)->get();
            \Log::info("Transaction value".$value['total_amount']);

            foreach($income_data as $data){
                // $total_roi_amount = 0;
                // $total_roi_amount = AccountTransaction::where('topup_id',$data->id)
                //                                         ->whereBetween(
                //                                             DB::raw('DATE(created_at)'), 
                //                                             [
                //                                                 format_date_for_db($this->start_date), 
                //                                                 format_date_for_db($this->end_date)
                //                                             ]
                //                                         )
                //                                         ->where('which_for','ROI Daily')
                //                                         ->where('status',1)
                //                                         // ->selectRaw('IF(COUNT(*) >= 30, SUM(amount), 0) as conditional_sum')
                //                                         ->sum('amount');
                // \Log::info("total roi amount : ".$total_roi_amount." of user ".$data->user?->name);
                $lastSaturday = Carbon::parse($this->start_date);
                $today = Carbon::parse($this->end_date);

                
                // Top-up start and end dates
                $topUpStartDate = Carbon::parse($data->start_date);
                $topUpEndDate = $data->end_date ? Carbon::parse($data->end_date) : null;

                // Calculate day difference based on the conditions
                if ($topUpStartDate->greaterThan($lastSaturday)) {
                    // Case 1: Top-up starts after last Saturday
                    $start = $topUpStartDate;
                    $end = $today;
                } elseif ($topUpEndDate && $topUpEndDate->lessThan($today)) {
                    // Case 2: Top-up ends before today and topUpEndDate is not null
                    $start = $lastSaturday;
                    $end = $topUpEndDate;
                } else {
                    // Case 3: Overlap between last Saturday and today
                    $start = $lastSaturday;
                    $end = $topUpEndDate ? $topUpEndDate : $today; // Use today if topUpEndDate is null
                }

                // Calculate day difference
                $days = $start->diffInDays($end) + 1;

                
                $user = User::find($data->user_id);

                $weeklyPayment = ($data->total_amount / get_days_in_this_month()) * $days;
                $weeklyPayment = round($weeklyPayment, 2);


                // $weeklyPayment = $total_roi_amount;
                if($user->sponsor){
                    $agent = $user->sponsor;
                    \Log::info("agent : ".json_encode($agent));
                    \Log::info("weeklyPayment : ".json_encode($weeklyPayment));
                    $this->levelBonusService->weekly_level_bonus($agent->user_id,$weeklyPayment,1,$user->id);
                }
            }
        }
    }
}
