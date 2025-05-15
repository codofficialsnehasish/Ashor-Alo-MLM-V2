<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\BinaryTree;

class BinaryTreeApiController extends Controller
{
    public function direct(Request $request){
        $user = User::find($request->user()->id);
        if($user){
            $leader = $user->binaryTreeNode;
            $directMembers = BinaryTree::where('sponsor_id', $leader->id)->with('user')->get();
            return apiResponse(true, 'Direct Members.', ['direct_members'=>$directMembers], 200);
        }
        return apiResponse(false, 'User not found.', null, 200);
    }

    public function left_side_members(Request $request){
        $user = User::find($request->user()->id);
        if($user){
            $leader = $user->binaryTreeNode;
            $leftMembers = $leader->leftUsers;
            return apiResponse(true, 'Left Members.', ['left_members'=>$leftMembers], 200);
        }
        return apiResponse(false, 'User not found.', null, 200);
    }

    public function right_side_members(Request $request){
        $user = User::find($request->user()->id);
        if($user){
            $leader = $user->binaryTreeNode;
            $rightMembers = $leader->rightUsers;
            return apiResponse(true, 'Right Members.', ['right_members'=>$rightMembers], 200);
        }
        return apiResponse(false, 'User not found.', null, 200);
    }

    public function all_members(Request $request) {
        $user = User::find($request->user()->id);
        if ($user) {
            $leader = $user->binaryTreeNode;
            
            // Get both left and right members
            $leftMembers = $leader->leftUsers ?? collect();
            $rightMembers = $leader->rightUsers ?? collect();
            
            // Combine both collections
            $allMembers = $leftMembers->merge($rightMembers);
            
            return apiResponse(true, 'All Members.', ['all_members' => $allMembers], 200);
        }
        
        return apiResponse(false, 'User not found.', null, 200);
    }
}