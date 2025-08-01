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
use App\Jobs\GeneratePayoutJob;

class CornJobsTest extends Controller
{
    // public function testJobsForDateRange()
    // {
    //     $startDate = Carbon::createFromDate(2025, 6, 30);
    //     $endDate = Carbon::createFromDate(2025, 7, 14);

    //     while ($startDate->lte($endDate)) {
    //         echo "<br>Running jobs for date: " . $startDate->toDateString() . PHP_EOL;
    //         echo "<br><br>";

    //         // Run ROI bonus every day
    //         $this->roi_bonus($startDate);
            
    //         // Check if it's the 15th or last day of the month
    //         $is15th = ($startDate->day === 15);
    //         $isLastDay = ($startDate->day === $startDate->daysInMonth);
            
    //         if ($is15th || $isLastDay) {
    //             $this->level_bonus($startDate);
    //             // $this->payout($startDate);
    //         }

    //         $startDate->addDay();
    //     }

    //     echo "<br>Finished running jobs.<br>";
    // }

    public function testJobsForDateRange()
    {
        $startDate = Carbon::createFromDate(2025, 7, 1);
        // $endDate = Carbon::createFromDate(2027, 8, 31);
        $endDate = Carbon::createFromDate(2025, 7, 31);

        while ($startDate->lte($endDate)) {
            echo "<br>Running jobs for date: " . $startDate->toDateString() . PHP_EOL;
            echo "<br><br>";

            // Run ROI bonus every day
            $this->roi_bonus($startDate);
            
            // Check if it's the 15th or last day of the month
            // $is15th = ($startDate->day === 15);
            // $isLastDay = ($startDate->day === $startDate->daysInMonth);
            
            // if ($is15th || $isLastDay) {
            //     // First process level bonus with job queue check
            //     $this->processWithJobQueueCheck('level_bonus', $startDate);
                
            //     // Then process payout with job queue check
            //     $this->processWithJobQueueCheck('payout', $startDate);
            // }

            $startDate->addDay();
        }

        echo "<br>Finished running jobs.<br>";
    }

    public function level_bonus_data_set(){

        $dateRanges = [
            // ['start_date' => '2025-05-16', 'end_date' => '2025-05-31'],
            ['start_date' => '2025-06-01', 'end_date' => '2025-06-15'],


            // ['start_date' => '2025-06-23', 'end_date' => '2025-06-30'],
            // ['start_date' => '2025-07-01', 'end_date' => '2025-07-15'],
            // ['start_date' => '2025-07-16', 'end_date' => '2025-07-31'],
            // ['start_date' => '2025-08-01', 'end_date' => '2025-08-15'],
            // ['start_date' => '2025-08-16', 'end_date' => '2025-08-31'],
            // ['start_date' => '2025-09-01', 'end_date' => '2025-09-15'],
            // ['start_date' => '2025-09-16', 'end_date' => '2025-09-30'],
            // ['start_date' => '2025-10-01', 'end_date' => '2025-10-15'],
            // ['start_date' => '2025-10-16', 'end_date' => '2025-10-31'],
            // ['start_date' => '2025-11-01', 'end_date' => '2025-11-15'],
            // ['start_date' => '2025-11-16', 'end_date' => '2025-11-30'],
            // ['start_date' => '2025-12-01', 'end_date' => '2025-12-15'],
            // ['start_date' => '2025-12-16', 'end_date' => '2025-12-31'],
            // ['start_date' => '2026-01-01', 'end_date' => '2026-01-15'],
            // ['start_date' => '2026-01-16', 'end_date' => '2026-01-31'],
            // ['start_date' => '2026-02-01', 'end_date' => '2026-02-15'],
            // ['start_date' => '2026-02-16', 'end_date' => '2026-02-28'],
            // ['start_date' => '2026-03-01', 'end_date' => '2026-03-15'],
            // ['start_date' => '2026-03-16', 'end_date' => '2026-03-31'],
            // ['start_date' => '2026-04-01', 'end_date' => '2026-04-15'],
            // ['start_date' => '2026-04-16', 'end_date' => '2026-04-30'],
            // ['start_date' => '2026-05-01', 'end_date' => '2026-05-15'],
            // ['start_date' => '2026-05-16', 'end_date' => '2026-05-31'],
            // ['start_date' => '2026-06-01', 'end_date' => '2026-06-15'],
            // ['start_date' => '2026-06-16', 'end_date' => '2026-06-30'],
            // ['start_date' => '2026-07-01', 'end_date' => '2026-07-15'],
            // ['start_date' => '2026-07-16', 'end_date' => '2026-07-31'],
            // ['start_date' => '2026-08-01', 'end_date' => '2026-08-15'],
            // ['start_date' => '2026-08-16', 'end_date' => '2026-08-31'],
            // ['start_date' => '2026-09-01', 'end_date' => '2026-09-15'],
            // ['start_date' => '2026-09-16', 'end_date' => '2026-09-30'],
            // ['start_date' => '2026-10-01', 'end_date' => '2026-10-15'],
            // ['start_date' => '2026-10-16', 'end_date' => '2026-10-31'],
            // ['start_date' => '2026-11-01', 'end_date' => '2026-11-15'],
            // ['start_date' => '2026-11-16', 'end_date' => '2026-11-30'],
            // ['start_date' => '2026-12-01', 'end_date' => '2026-12-15'],
            // ['start_date' => '2026-12-16', 'end_date' => '2026-12-31'],
            // ['start_date' => '2027-01-01', 'end_date' => '2027-01-15'],
            // ['start_date' => '2027-01-16', 'end_date' => '2027-01-31'],
            // ['start_date' => '2027-02-01', 'end_date' => '2027-02-15'],
            // ['start_date' => '2027-02-16', 'end_date' => '2027-02-28'],
            // ['start_date' => '2027-03-01', 'end_date' => '2027-03-15'],
            // ['start_date' => '2027-03-16', 'end_date' => '2027-03-31'],
            // ['start_date' => '2027-04-01', 'end_date' => '2027-04-15'],
            // ['start_date' => '2027-04-16', 'end_date' => '2027-04-30'],
            // ['start_date' => '2027-05-01', 'end_date' => '2027-05-15'],
            // ['start_date' => '2027-05-16', 'end_date' => '2027-05-31'],
            // ['start_date' => '2027-06-01', 'end_date' => '2027-06-15'],
            // ['start_date' => '2027-06-16', 'end_date' => '2027-06-30'],
            // ['start_date' => '2027-07-01', 'end_date' => '2027-07-15'],
            // ['start_date' => '2027-07-16', 'end_date' => '2027-07-31'],
            // ['start_date' => '2027-08-01', 'end_date' => '2027-08-15'],
            // ['start_date' => '2027-08-16', 'end_date' => '2027-08-31']
        ];

        foreach ($dateRanges as $dateRange) {
            $startDate = $dateRange['start_date'];
            $endDate = $dateRange['end_date'];
            
            // Call your function with these dates
            // $this->level_bonus($startDate, $endDate);
            $this->payout($startDate, $endDate);
        }


    }

    /**
     * Process a job after ensuring the jobs table is empty
     * 
     * @param string $methodName The method to call (e.g., 'level_bonus', 'payout')
     * @param Carbon $date The date to process
     * @param int $maxAttempts Maximum number of attempts to wait for jobs to complete
     * @param int $sleepTime Seconds to wait between checks
     */
    protected function processWithJobQueueCheck($methodName, $date, $maxAttempts = 30, $sleepTime = 10)
    {
        $attempts = 0;
        
        // First check if there are pending jobs
        while ($this->hasPendingJobs() && $attempts < $maxAttempts) {
            $attempts++;
            echo "<br>Waiting for jobs table to empty before processing {$methodName}... (Attempt {$attempts}/{$maxAttempts})";
            sleep($sleepTime);
        }
        
        if ($this->hasPendingJobs()) {
            echo "<br>Timeout reached while waiting for jobs table to empty. {$methodName} not processed for {$date->toDateString()}.";
            return;
        }
        
        // Process the method
        echo "<br>Processing {$methodName} for {$date->toDateString()}...";
        $this->{$methodName}($date);
        echo "<br>{$methodName} completed for {$date->toDateString()}.";
        
        // Optional: Wait again after processing to ensure any spawned jobs are complete
        // This might be useful if your methods create new jobs
        $attempts = 0;
        while ($this->hasPendingJobs() && $attempts < $maxAttempts) {
            $attempts++;
            echo "<br>Waiting for spawned jobs to complete after {$methodName}... (Attempt {$attempts}/{$maxAttempts})";
            sleep($sleepTime);
        }
    }

    public function generate_dates(){
        $startDate = Carbon::createFromDate(2025, 6, 23);
        $endDate = Carbon::createFromDate(2027, 8, 31);

        $dateRanges = [];
        $current = $startDate->copy();

        // Adjust the first period if we're starting mid-month
        if ($current->day > 1 && $current->day < 16) {
            $periodStart = $current->copy();
            $periodEnd = $current->copy()->day(15);
            
            if ($periodEnd->greaterThanOrEqualTo($periodStart)) {
                $dateRanges[] = [
                    'start_date' => $periodStart->format('Y-m-d'),
                    'end_date' => $periodEnd->format('Y-m-d')
                ];
            }
            
            $current = $current->copy()->day(16);
        } elseif ($current->day > 15) {
            $periodStart = $current->copy();
            $periodEnd = $current->copy()->endOfMonth();
            
            if ($periodEnd->greaterThanOrEqualTo($periodStart)) {
                $dateRanges[] = [
                    'start_date' => $periodStart->format('Y-m-d'),
                    'end_date' => $periodEnd->format('Y-m-d')
                ];
            }
            
            $current = $current->copy()->addMonth()->startOfMonth();
        }

        // Generate the regular periods
        while ($current->lessThanOrEqualTo($endDate)) {
            // First half of month (1st to 15th)
            $periodEnd = $current->copy()->day(15);
            if ($periodEnd->greaterThan($endDate)) {
                $periodEnd = $endDate;
            }
            
            if ($current->lessThanOrEqualTo($periodEnd)) {
                $dateRanges[] = [
                    'start_date' => $current->format('Y-m-d'),
                    'end_date' => $periodEnd->format('Y-m-d')
                ];
            }
            
            $current = $current->copy()->day(16);
            if ($current->greaterThan($endDate)) break;
            
            // Second half of month (16th to end)
            $periodEnd = $current->copy()->endOfMonth();
            if ($periodEnd->greaterThan($endDate)) {
                $periodEnd = $endDate;
            }
            
            if ($current->lessThanOrEqualTo($periodEnd)) {
                $dateRanges[] = [
                    'start_date' => $current->format('Y-m-d'),
                    'end_date' => $periodEnd->format('Y-m-d')
                ];
            }
            
            $current = $current->copy()->addMonth()->startOfMonth();
        }

        // Output the result
        print_r($dateRanges);
    }

    /**
     * Check if there are pending jobs in the jobs table
     * 
     * @return bool True if there are pending jobs, false otherwise
     */
    protected function hasPendingJobs()
    {
        // Assuming you're using Laravel's default jobs table
        return DB::table('jobs')->exists();
        
        // Alternative if you have a different setup:
        // return DB::table('jobs')->where('attempts', '<', $maxAttempts)
        //     ->orWhereNull('reserved_at')
        //     ->orWhereNull('processed_at')
        //     ->exists();
    }

    public function roi_bonus($currentDate = null)
    {
        $this->process_direct_bonus($currentDate);

        $income_data = TopUp::where('is_completed', 0)
            ->whereColumn('total_installment_month', '>=', 'month_count')
            ->whereDate('start_date', '!=', $currentDate ?? now()->toDateString())
            ->get();

        $chunks = $income_data->chunk(15);
        foreach ($chunks as $chunk) {
            RoiJob::dispatch($chunk, $currentDate);
        }
    }

    public function process_direct_bonus($currentDate = null)
    {
        $date = $currentDate ?? now()->toDateString();
        $today_join_users = TopUp::whereDate('created_at', $date)->where('is_provide_direct', 1)->get();

        foreach ($today_join_users as $join_data) {
            $member = User::find($join_data->user_id);

            if ($member && $member->sponsor) {
                $agent = $member->sponsor;

                if (!AccountTransaction::where('user_id', $agent->user_id)
                    ->where('which_for', 'Direct Bonus')
                    ->whereDate('created_at', $date)
                    ->where('topup_id', $join_data->id)
                    ->exists()) {

                    if ($agent->status == 1) {
                        $mlm_settings = MlmSetting::first();
                        $user_bonus = ($join_data->total_amount * ($mlm_settings->agent_direct_bonus / 100));

                        AccountTransaction::create([
                            'user_id' => $agent->user_id,
                            'amount' => $user_bonus,
                            'which_for' => 'Direct Bonus',
                            'status' => 1,
                            'generated_against_user_id' => $member->id,
                            'topup_id' => $join_data->id,
                            'created_at' => $date,
                            'updated_at' => $date,
                        ]);
                    }
                }
            }
        }
    }

    public function level_bonus($startDate = null,$endDate = null)
    {
        // $last_payout_date = Payout::latest('end_date')->first()?->end_date;
        // $lastSaturday = Carbon::parse($last_payout_date ?? now())->addDay();
        // $current_day = Carbon::parse($currentDate ?? now());

        // \Log::info("lastSaturday => ".$lastSaturday);
        // \Log::info("current_day => ".$current_day);

        $lastSaturday = Carbon::parse($startDate ?? now());
        $current_day = Carbon::parse($endDate ?? now());

        \Log::info("Processing level bonus from {$lastSaturday} to {$current_day}");

        // $acc_transactions = AccountTransaction::whereBetween(DB::raw('DATE(created_at)'), [format_date_for_db($lastSaturday), format_date_for_db($current_day)])
        //     ->where('which_for', 'ROI Daily')
        //     ->select('user_id', DB::raw('DATE(created_at) as payment_date'))
        //     ->distinct()
        //     ->get()
        //     ->groupBy('user_id')
        //     ->map(function ($transactions) {
        //         return $transactions->pluck('payment_date')->unique()->count();
        //     });
        $acc_transactions = AccountTransaction::whereBetween(DB::raw('DATE(created_at)'), [format_date_for_db($lastSaturday), format_date_for_db($current_day)])
            ->where('which_for', 'ROI Daily')
            ->select('user_id', DB::raw('DATE(created_at) as payment_date'), 'amount')
            ->get()
            ->groupBy('user_id')
            ->map(function ($transactions) {
                return [
                    'unique_dates_count' => $transactions->pluck('payment_date')->unique()->count(),
                    'total_amount' => number_format($transactions->sum('amount'), 2, '.', '')
                ];
            });
        \Log::info("On Level Bonus Job".json_encode($acc_transactions));
        $chunks = $acc_transactions->chunk(5);
        
        foreach ($chunks as $chunk) {
            \Log::info("Generating Level Bonus Job");
            LevelBonusJob::dispatch($chunk, $lastSaturday, $current_day);
        }
    }

    public function payout($startDate = null,$endDate = null)
    {
        // $last_payout_date = Payout::latest('end_date')->first()?->end_date;
        // $lastSaturday = Carbon::parse($last_payout_date ?? now())->addDay();
        // $current_day = Carbon::parse($currentDate ?? now());

        $lastSaturday = Carbon::parse($startDate ?? now());
        $current_day = Carbon::parse($endDate ?? now());

        $transactions = BinaryTree::where('status', 1)->pluck('user_id');

        $chunks = $transactions->chunk(5);
        foreach ($chunks as $chunk) {
            // PayoutJob::dispatch($chunk, $lastSaturday, $current_day);
            GeneratePayoutJob::dispatch($chunk, $lastSaturday, $current_day);
        }
    }
}
