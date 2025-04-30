<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\BinaryTree;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_number' => 'required|digits:8|exists:binary_trees,member_number',
            'password' => 'required|min:4',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', $validator->errors(), 422);
        }

        $sponsor = BinaryTree::where('member_number',$request->member_number)->with('user')->first();

        if (!$sponsor || !Hash::check($request->password, $sponsor->user->password)) {
            return apiResponse(false, 'Invalid credentials', null, 401);
        }

        if (! $sponsor->user->hasRole('Leader')) {
            return apiResponse(false, 'Unauthorized. Only Leaders can login.', null, 403);
        }

        $token = $sponsor->user->createToken('leader_token')->plainTextToken;

        return apiResponse(true, 'Login successful', ['token' => $token, 'user' => $sponsor->user], 200);
    }

    public function getSponsorName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_number' => 'required|digits:8|exists:binary_trees,member_number',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', $validator->errors(), 422);
        }
        
        $sponsor = BinaryTree::where('member_number',$request->member_number)->with('user')->first();
        $this->sponsorName = $sponsor ? $sponsor->user->name : 'Not found';
        return apiResponse(true, 'Sponsor Name Get Successfully', ['sponsor_name' => $sponsor->user->name], 200);
    }
}
