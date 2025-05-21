<?php
namespace App\Services;

use App\Models\User;
use App\Models\LevelBonusMaster;
use App\Models\AccountTransaction;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LevelBonusService
{
    public function weekly_level_bonus($user_id, $amount, $user_level, $main_user_id){
        $user = User::where('id', $user_id)->first();

        if($user_id == null) { return; }

        if (empty($user)) { return; }

        $highest_level = LevelBonusMaster::latest()->first();

        if($user_level > $highest_level->level_number){ return; }

        if($user->binaryTreeNode->status == 1){

            $user_lavel_persentage = LevelBonusMaster::where('level_number', $user_level)->value('level_percentage');
            $user_lavel_persentage = number_format($user_lavel_persentage, 1);
            $bonus = round($amount * ($user_lavel_persentage/100),2);

            $transaction = AccountTransaction::create([
                'user_id' => $user->id,
                'amount' => $bonus,
                'which_for' => 'Level Bonus',
                'status' => 1,
                'generated_against_user_id' => $main_user_id,
            ]);
        }

        if($user->sponsor){
            $agent = $user->sponsor;

            $this->weekly_level_bonus($agent->user_id, $amount, $user_level += 1,$main_user_id);
        }
    }
    
}