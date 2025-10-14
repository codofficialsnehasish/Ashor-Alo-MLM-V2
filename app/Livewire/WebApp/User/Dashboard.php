<?php

namespace App\Livewire\WebApp\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Payout;
use App\Models\Orders;
use App\Models\AccountTransaction;
use App\Models\User;
use App\Models\TopUp;
use App\Models\BinaryTree;
use App\Models\RemunerationBenefitMaster;
use App\Models\RepurchaseAccount;

class Dashboard extends Component
{
    public $total_income,
            $total_commission,
            $hold_amount,
            $direct_bonus,
            $level_bonus,
            $product_return,
            $direct_team_member,
            $total_topup_amount,
            $remuneration_benefits,
            $repurchase_bonus,
            $last_payment,
            $dilse_amount,
            $left_team_member,
            $right_team_member,
            $tree_team_member,
            $level_team_member,
            $total_active_team_member,
            $total_team_member,
            $rank,
            $total_left_business,
            $total_right_business,
            $current_week_business,
            $current_week_left_business,
            $current_week_right_business;

    public function mount()
    {
        $userId = Auth::id();
        $user   = Auth::user();
        $leader = $user->binaryTreeNode;

        $total = Payout::where('user_id', $user->id)
                        ->selectRaw('SUM(direct_bonus) as direct_bonus, SUM(lavel_bonus) as lavel_bonus, SUM(remuneration_bonus) as remuneration_bonus, SUM(roi) as roi, SUM(dilse_payout_amount) as dilse_bonus')
                        ->first();

        // replicate your old logic here
        $this->total_income       = number_format($total->direct_bonus + $total->lavel_bonus + $total->remuneration_bonus + $total->roi + $total->dilse_bonus,2);
        
        $comision_total = Payout::where('user_id', $user->id)
                        ->selectRaw('
                            SUM(direct_bonus - direct_bonus_tds_deduction - direct_bonus_repurchase_deduction) as direct_bonus, 
                            SUM(lavel_bonus - lavel_bonus_tds_deduction - lavel_bonus_repurchase_deduction) as lavel_bonus, 
                            SUM(remuneration_bonus - remuneration_bonus_tds_deduction - remuneration_bonus_repurchase_deduction) as remuneration_bonus, 
                            SUM(roi - roi_tds_deduction) as roi,
                            SUM(dilse_payout_amount - dilse_service_charge_deduction) as dilse_bonus
                        ')
                        ->first();
        $this->total_commission   = number_format($comision_total->direct_bonus + $comision_total->lavel_bonus + $comision_total->remuneration_bonus + $comision_total->roi + $comision_total->dilse_bonus,2);
        $this->hold_amount        = Payout::where('user_id', $user->id)->latest()->value('hold_amount');
        $this->direct_bonus       = AccountTransaction::whereIn('which_for', ['Direct Bonus', 'Direct Bonus on Hold'])
                                                    ->where('user_id', $user->id)
                                                    ->sum('amount');
        $this->level_bonus        = AccountTransaction::whereIn('which_for', ['Level Bonus','Level Bonus on Hold'])->where('user_id',$user->id)->sum('amount');
        $this->product_return     =  AccountTransaction::where('which_for','ROI Daily')->where('user_id',$user->id)->sum('amount');
        $this->direct_team_member = BinaryTree::where('sponsor_id', $leader->id)->with('user')->count();
        $this->total_topup_amount = TopUp::where('user_id',$userId)->sum('total_amount');
        $this->remuneration_benefits = AccountTransaction::where('which_for','Salary Bonus')->where('user_id',$user->id)->sum('amount');
        $this->repurchase_bonus   = RepurchaseAccount::where('user_id',$user->id)->sum('amount');
        $this->last_payment       = Payout::where('user_id', $userId)->latest()->first();
        $this->dilse_amount       = TopUp::where('user_id',$user->id)->whereNull('add_on_against_order_id')
                                                ->where('is_provide_roi',1)
                                                ->where('is_provide_level',0)
                                                ->where('is_provide_direct',0)->sum('total_amount');

        // team/business calculations
        $this->left_team_member   = $leader->leftUsers->count();
        $this->right_team_member  = $leader->rightUsers->count();

        $leftMembers = $leader->leftUsers ?? collect();
        $rightMembers = $leader->rightUsers ?? collect();
        $allMembers = $leftMembers->merge($rightMembers);

        $this->total_team_member  = $allMembers->count();
        $this->tree_team_member   = 0;
        $this->level_team_member  = 0;
        $this->total_active_team_member = $allMembers->where('status',1)->count();

        $this->total_left_business = $leader->calculateLeftBusiness();
        $this->total_right_business = $leader->calculateRightBusiness();
        $achieved_target = RemunerationBenefitMaster::where('matching_target', '<=', $this->total_left_business)
                            ->where('matching_target', '<=', $this->total_right_business)
                            ->orderBy('matching_target', 'DESC')
                            ->first();

        $this->rank               = $achieved_target->rank_name ?? 'N/A';
        

        $this->current_week_business       = 0;
        $this->current_week_left_business  = 0;
        $this->current_week_right_business = 0;
    }

    public function render()
    {
        return view('livewire.web-app.user.dashboard')
            ->layout('livewire.web-app.user.user-dashboard.partials.layout');
    }
}
