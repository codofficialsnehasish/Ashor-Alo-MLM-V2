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
    }
}