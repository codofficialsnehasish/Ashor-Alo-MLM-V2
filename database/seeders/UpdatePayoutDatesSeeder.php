<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BinaryTree;

class UpdatePayoutDatesSeeder extends Seeder
{
    public function run()
    {
        $trees = BinaryTree::all();

        foreach ($trees as $tree) {
            $user = $tree->user;
            $payout_type = calculatePayoutDate($user->id);
            $this->command->info('User'.$user->name.'and the payout type - '.$payout_type);
            if ($payout_type) {
                $tree->update([
                    'payout_type' => $payout_type
                ]);
            }
        }

        echo "Payout dates updated successfully.\n";
    }
}
