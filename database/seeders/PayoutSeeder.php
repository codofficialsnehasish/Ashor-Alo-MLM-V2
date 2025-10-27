<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Payout;

class PayoutSeeder extends Seeder
{

    protected $dataFiles = [
        'p1.php',
        'p2.php',
        'p3.php',
        'p4.php',
        'p5.php',
        'p6.php',
        'p7.php',
        'p8.php',
        'p9.php',
        'p10.php',
        'p11.php',
    ];
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($this->dataFiles as $file) {
            $this->command->info("Processing file: {$file}");
            $path = database_path('seeders/data/payout_data/' . $file);
            
            if (!file_exists($path)) {
                $this->command->error("File not found: {$path}");
                continue;
            }

            $Payout = require $path;
            
            $counter = 1;
            $total = count($Payout);
            
            foreach ($Payout as $payout) {
                $this->command->info("Processing payout {$counter} of {$total} (ID: {$payout['id']})");
                $counter++;
                
                // Skip if transaction already exists
                if (Payout::where('id', $payout['id'])->exists()) {
                    $this->command->warn("Payout ID {$payout['id']} already exists, skipping...");
                    continue;
                }
                
                try {
                    $payoutRecord = new Payout();
                    
                    // Set all fillable attributes
                    $payoutRecord->id = $payout['id'];
                    $payoutRecord->user_id = $payout['user_id'];
                    $payoutRecord->start_date = $payout['start_date'];
                    $payoutRecord->end_date = $payout['end_date'];
                    $payoutRecord->tds_persentage = $payout['tds_persentage'];
                    $payoutRecord->repurchase_persentage = $payout['repurchase_persentage'];
                    $payoutRecord->service_charge_persentage = $payout['service_charge_persentage'];
                    $payoutRecord->direct_bonus = $payout['direct_bonus'];
                    $payoutRecord->direct_bonus_tds_deduction = $payout['direct_bonus_tds_deduction'];
                    $payoutRecord->direct_bonus_repurchase_deduction = $payout['direct_bonus_repurchase_deduction'];
                    $payoutRecord->lavel_bonus = $payout['lavel_bonus'];
                    $payoutRecord->lavel_bonus_tds_deduction = $payout['lavel_bonus_tds_deduction'];
                    $payoutRecord->lavel_bonus_repurchase_deduction = $payout['lavel_bonus_repurchase_deduction'];
                    $payoutRecord->remuneration_bonus = $payout['remuneration_bonus'];
                    $payoutRecord->remuneration_bonus_tds_deduction = $payout['remuneration_bonus_tds_deduction'];
                    $payoutRecord->remuneration_bonus_repurchase_deduction = $payout['remuneration_bonus_repurchase_deduction'];
                    $payoutRecord->dilse_payout_amount = $payout['dilse_payout_amount'];
                    $payoutRecord->dilse_service_charge_deduction = $payout['dilse_service_charge_deduction'];
                    $payoutRecord->roi = $payout['roi'];
                    $payoutRecord->roi_tds_deduction = $payout['roi_tds_deduction'];
                    $payoutRecord->hold_amount_added = $payout['hold_amount_added'];
                    $payoutRecord->hold_amount = $payout['hold_amount'];
                    $payoutRecord->hold_wallet_added = $payout['hold_wallet_added'];
                    $payoutRecord->hold_wallet = $payout['hold_wallet'];
                    $payoutRecord->previous_unpaid_amount = $payout['previous_unpaid_amount'];
                    $payoutRecord->total_payout = $payout['total_payout'];
                    $payoutRecord->paid_unpaid = $payout['paid_unpaid'];
                    $payoutRecord->paid_date = $payout['paid_date'];
                    $payoutRecord->paid_mode = $payout['paid_mode'];
                    
                    // Set timestamps
                    $payoutRecord->created_at = $payout['created_at'] ?? now();
                    $payoutRecord->updated_at = $payout['updated_at'] ?? now();
                    
                    $payoutRecord->save();
                    
                    $this->command->info("Successfully added payout ID: {$payout['id']}");
                } catch (\Exception $e) {
                    $this->command->error("Error processing payout ID {$payout['id']}: " . $e->getMessage());
                }
                
                // Free memory
                unset($payoutRecord);
                gc_collect_cycles();
            }
            
            unset($Payout);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
