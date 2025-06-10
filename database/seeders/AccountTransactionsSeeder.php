<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AccountTransaction;
use Illuminate\Support\Facades\DB;

class AccountTransactionsSeeder extends Seeder
{

    protected $dataFiles = [
        't1.php',
        't2.php',
        't3.php',
        't4.php',
        't5.php',
        't6.php',
        't7.php',
        't8.php',
        't9.php',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach ($this->dataFiles as $file) {
            $this->command->info("Processing file: {$file}");
            $path = database_path('seeders/data/transaction_data/' . $file);
            
            if (!file_exists($path)) {
                $this->command->error("File not found: {$path}");
                continue;
            }

            $AccountTransaction = require $path;
            
            $counter = 1;
            $total = count($AccountTransaction);
            
            foreach ($AccountTransaction as $t) {
                $this->command->info("Processing transaction {$counter} of {$total} (ID: {$t['id']})");
                $counter++;
                
                // Skip if transaction already exists
                if (AccountTransaction::where('id', $t['id'])->exists()) {
                    $this->command->warn("Transaction ID {$t['id']} already exists, skipping...");
                    continue;
                }
                
                try {
                    $transaction = new AccountTransaction();
                    $transaction->id = $t['id'];
                    $transaction->user_id = $t['user_id'];
                    $transaction->amount = $t['amount'];
                    $transaction->which_for = $t['which_for'];
                    $transaction->status = $t['status'];
                    $transaction->generated_against_user_id = $t['generated_against_id'];
                    $transaction->topup_id = null;
                    $transaction->created_at = $t['created_at'] ?? now();
                    $transaction->updated_at = $t['updated_at'] ?? now();
                    $transaction->save();
                    
                    $this->command->info("Successfully added transaction ID: {$t['id']}");
                } catch (\Exception $e) {
                    $this->command->error("Error processing transaction ID {$t['id']}: " . $e->getMessage());
                }
                
                // Free memory
                unset($chunk);
                gc_collect_cycles();
            }
            
            unset($AccountTransaction);
        }
        // Sample data array
    }
}