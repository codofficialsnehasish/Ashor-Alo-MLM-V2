<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\TopUp;
use App\Models\BinaryTree; 
use App\Models\AccountTransaction;
use Carbon\Carbon;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RoiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $income_data;
    /**
     * Create a new job instance.
     */
    public function __construct($income_data)
    {
        $this->income_data = $income_data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->income_data as $data) {
            // Skip if already completed
            if($data->is_completed == 1) {
                continue;
            }

            $is_transacted = 0;
            $transactionType = null;

            // Determine transaction type based on business rules
            if($data->is_provide_direct == 0 && $data->is_provide_roi == 1 && $data->is_provide_level == 0) {
                $transactionType = ($data->add_on_against_order_id != null) ? 'ROI Dailys' : 'DILSE Daily';
            } else {
                $transactionType = 'ROI Daily';
            }

            // Check if transaction already exists for today
            $transactionExists = AccountTransaction::where('user_id', $data->user_id)
                ->where('which_for', $transactionType)
                ->whereDate('created_at', today())
                ->where('topup_id', $data->id)
                ->exists();

            if(!$transactionExists) {
                // Check if we would exceed total_paying_amount
                $amount_to_disburse = $data->installment_amount_per_day;
                $remaining_amount = $data->total_paying_amount - $data->total_disbursed_amount;

                if($remaining_amount <= 0) {
                    $top_up = TopUp::find($data->id);
                    $top_up->is_completed = 1;
                    $top_up->end_date = now();
                    $top_up->save();
                    continue;
                }

                if($amount_to_disburse > $remaining_amount) {
                    $amount_to_disburse = $remaining_amount;
                }

                // Create transaction
                $transaction = AccountTransaction::create([
                    'user_id' => $data->user_id,
                    'amount' => $amount_to_disburse,
                    'which_for' => $transactionType,
                    'status' => 1,
                    'topup_id' => $data->id,
                ]);

                $is_transacted = 1;
            }

            if($is_transacted) {
                $top_up = TopUp::find($data->id);
                
                // Increment day count
                $top_up->days_count += 1;
                
                // Check for month increment
                if(Carbon::now()->day == Carbon::parse($data->start_date)->day) {
                    $top_up->month_count += 1;
                }
                
                // Update disbursed amount
                $top_up->total_disbursed_amount += $amount_to_disburse;
                
                // Check for completion conditions
                if($top_up->total_disbursed_amount >= $top_up->total_paying_amount || $top_up->month_count >= $top_up->total_installment_month || $top_up->days_count >= $top_up->total_installment_days) {
                    $top_up->is_completed = 1;
                    $top_up->end_date = now();
                }
                
                $top_up->save();
            }
        }
    }
}
