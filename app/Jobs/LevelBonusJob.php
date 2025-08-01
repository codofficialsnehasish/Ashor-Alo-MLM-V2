<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\TopUp;
use App\Services\LevelBonusService;
use Illuminate\Bus\Queueable;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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

            $income_data = TopUp::where('user_id',$key)->get();

            foreach($income_data as $data){
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
                if($user->sponsor){
                    $agent = $user->sponsor;
                    $this->levelBonusService->weekly_level_bonus($agent->user_id,$weeklyPayment,1,$user->id);
                }
            }
        }
    }
}
