<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BinaryTree;
use App\Models\TopUp;
use App\Models\BankDetail;
use App\Models\Nominee;
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
            $data['total_income'] = 0.00;
            $data['total_commission'] = 0.00;
            $data['hold_amount'] = 0.00;
            $data['direct_bonus'] = 0.00;
            $data['level_bonus'] = 0.00;
            $data['product_support'] = 0.00;
            $data['remuneration_benefits'] = 0.00;
            $data['repurchase_wallet'] = 0.00;
            $data['direct_team_member'] = BinaryTree::where('sponsor_id', $leader->id)->with('user')->count();
            $data['left_team_member'] = $leader->leftUsers->count();
            $data['right_team_member'] = $leader->rightUsers->count();

            $leftMembers = $leader->leftUsers ?? collect();
            $rightMembers = $leader->rightUsers ?? collect();
            $allMembers = $leftMembers->merge($rightMembers);

            $data['all_team_member'] = $allMembers->count();
            $data['level_team_member'] = 1953;
            $data['active_team_member'] = $allMembers->where('status',1)->count();
            $data['rank'] = "";
            $data['total_topup_amount'] = TopUp::where('user_id',$request->user()->id)->sum('total_amount');

            $left_user_ids = $leader->leftUsers->pluck('user_id');
            $data['left_business'] = TopUp::whereIn('user_id', $left_user_ids)->sum('total_amount');

            $right_user_ids = $leader->rightUsers->pluck('user_id');
            $data['right_business'] = TopUp::whereIn('user_id', $right_user_ids)->sum('total_amount');
            $data['current_fortnight_business'] = 0.00;
            $data['last_payment'] = 0.00;
            $data['dilse_plan_invested'] = 0.00;

            return apiResponse(true, 'User Dashboard', $data, 200);
        }
        return apiResponse(false, 'User not found.', null, 200);
    }
}