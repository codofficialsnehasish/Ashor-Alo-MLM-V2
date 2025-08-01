<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BinaryTree;
use App\Models\TopUp;
use App\Models\Payout;
use App\Models\BankDetail;
use App\Models\Nominee;
use App\Models\AccountTransaction;
use App\Models\Advance;
use App\Models\AdvanceTransaction;
use App\Models\RepurchaseAccount;
use App\Models\RemunerationBenefitMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserDashboardAPI extends Controller
{
    public function dashboard(Request $request){
        $user = User::find($request->user()->id);
        if($user){
            $leader = $user->binaryTreeNode;
            $data = [];
            $total = Payout::where('user_id', $user->id)
                        ->selectRaw('SUM(direct_bonus) as direct_bonus, SUM(lavel_bonus) as lavel_bonus, SUM(remuneration_bonus) as remuneration_bonus, SUM(roi) as roi, SUM(dilse_payout_amount) as dilse_bonus')
                        ->first();
            // return $total->direct_bonus;

            $data['total_income'] = number_format($total->direct_bonus + $total->lavel_bonus + $total->remuneration_bonus + $total->roi + $total->dilse_bonus,2);
            $comision_total = Payout::where('user_id', $user->id)
                        ->selectRaw('
                            SUM(direct_bonus - direct_bonus_tds_deduction - direct_bonus_repurchase_deduction) as direct_bonus, 
                            SUM(lavel_bonus - lavel_bonus_tds_deduction - lavel_bonus_repurchase_deduction) as lavel_bonus, 
                            SUM(remuneration_bonus - remuneration_bonus_tds_deduction - remuneration_bonus_repurchase_deduction) as remuneration_bonus, 
                            SUM(roi - roi_tds_deduction) as roi,
                            SUM(dilse_payout_amount - dilse_service_charge_deduction) as dilse_bonus
                        ')
                        ->first();

            $data['total_commission'] = number_format($comision_total->direct_bonus + $comision_total->lavel_bonus + $comision_total->remuneration_bonus + $comision_total->roi + $comision_total->dilse_bonus,2);
            $data['hold_amount'] = Payout::where('user_id', $user->id)->latest()->value('hold_amount');
            $data['direct_bonus'] = AccountTransaction::whereIn('which_for', ['Direct Bonus', 'Direct Bonus on Hold'])
                                                    ->where('user_id', $user->id)
                                                    ->sum('amount');
            $data['level_bonus'] = AccountTransaction::whereIn('which_for', ['Level Bonus','Level Bonus on Hold'])->where('user_id',$user->id)->sum('amount');
            $data['product_support'] = AccountTransaction::where('which_for','ROI Daily')->where('user_id',$user->id)->sum('amount');
            $data['remuneration_benefits'] = AccountTransaction::where('which_for','Salary Bonus')->where('user_id',$user->id)->sum('amount');
            $data['dilse_bonus'] = AccountTransaction::where('which_for','DILSE Daily')->where('user_id',$user->id)->sum('amount');
            $data['repurchase_wallet'] = RepurchaseAccount::where('user_id',$user->id)->sum('amount');
            $data['direct_team_member'] = BinaryTree::where('sponsor_id', $leader->id)->with('user')->count();
            $data['left_team_member'] = $leader->leftUsers->count();
            $data['right_team_member'] = $leader->rightUsers->count();

            $leftMembers = $leader->leftUsers ?? collect();
            $rightMembers = $leader->rightUsers ?? collect();
            $allMembers = $leftMembers->merge($rightMembers);

            $data['all_team_member'] = $allMembers->count();
            $data['level_team_member'] = 1953;
            $data['active_team_member'] = $allMembers->where('status',1)->count();
            $total_left_business = $leader->calculateLeftBusiness();
            $total_right_business = $leader->calculateRightBusiness();

            $achieved_target = RemunerationBenefitMaster::where('matching_target', '<=', $total_left_business)
                            ->where('matching_target', '<=', $total_right_business)
                            ->orderBy('matching_target', 'DESC')
                            ->first();

            $data['rank'] = $achieved_target->rank_name ?? 'N/A';
            $data['total_topup_amount'] = TopUp::where('user_id',$request->user()->id)->sum('total_amount');

            $data['left_business'] = $leader->calculateLeftBusiness();
            $data['right_business'] = $leader->calculateRightBusiness();
            
            $data['todays_business'] = [
                'amount' => $leader->calculateLeftBusiness(date('Y-m-d'),date('Y-m-d')) + $leader->calculateRightBusiness(date('Y-m-d'),date('Y-m-d')),
                'today_left_business' => $leader->calculateLeftBusiness(date('Y-m-d'),date('Y-m-d')),
                'today_right_business' => $leader->calculateRightBusiness(date('Y-m-d'),date('Y-m-d')),
            ];
            
            
            // $data['today_left_business'] = $leader->calculateLeftBusiness(date('Y-m-d'),date('Y-m-d'));
            // $data['today_right_business'] = $leader->calculateRightBusiness(date('Y-m-d'),date('Y-m-d'));

            // Get current date
            $currentDate = date('Y-m-d');
            $dayOfMonth = date('j'); // Day of month without leading zeros (1-31)

            // Determine start and end dates based on current day
            if ($dayOfMonth >= 1 && $dayOfMonth <= 15) {
                // First fortnight (1st to 15th)
                $startDate = date('Y-m-01'); // First day of current month
                $endDate = date('Y-m-15');  // 15th of current month
            } else {
                // Second fortnight (16th to end of month)
                $startDate = date('Y-m-16'); // 16th of current month
                $endDate = date('Y-m-t');   // Last day of current month (t gives number of days in month)
            }

            $data['current_fortnight_business'] = $leader->calculateLeftBusiness($startDate, $endDate) + $leader->calculateRightBusiness($startDate, $endDate);
            $data['last_payment'] = Payout::where('user_id', $request->user()->id)->latest()->value('total_payout');
            $data['dilse_plan_invested'] = TopUp::where('user_id',$request->user()->id)->whereNull('add_on_against_order_id')
                                                ->where('is_provide_roi',1)
                                                ->where('is_provide_level',0)
                                                ->where('is_provide_direct',0)->sum('total_amount');

            $data['advance'] = Advance::where('user_id',$request->user()->id)->sum('balance');

            return apiResponse(true, 'User Dashboard', $data, 200);
        }
        return apiResponse(false, 'User not found.', null, 200);
    }
}