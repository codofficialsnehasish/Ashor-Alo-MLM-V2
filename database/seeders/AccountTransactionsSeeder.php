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
        't10.php',
        't11.php',
        't12.php',
        't13.php',
        't14.php',
        't15.php',
        't16.php',
        't17.php',
        't18.php',
        't19.php',
        't20.php',
        't21.php',
        't22.php',
        't23.php',
        't24.php',
        't25.php',
        't26.php',
        't27.php',
        't28.php',
        't29.php',
        't30.php',
        't31.php',
        't32.php',
        't33.php',
        't34.php',
        't35.php',
        't36.php',
        't37.php',
        't38.php',
        't39.php',
        't40.php',
        't41.php',
        't42.php',
        't43.php',
        't44.php',
        't45.php',
        't46.php',
        't47.php',
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

            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

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

            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            unset($AccountTransaction);
        }
        // Sample data array
    }
}