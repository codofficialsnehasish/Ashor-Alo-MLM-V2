<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\BinaryTree;
use App\Services\BinaryTreeService;
use App\Services\SMSService;

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

    public function register(Request $request, BinaryTreeService $binaryTreeService){
        // Step 1: Validate inputs
        $validator = Validator::make($request->all(), [
            'sponsor_id' => 'nullable|exists:binary_trees,member_number',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits:10|regex:/^[6789]/|unique:users,phone',
            'preferred_position' => 'required|in:left,right',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', $validator->errors(), 422);
        }

        // Step 2: Create the node using the BinaryTreeService
        try {
            $result = $binaryTreeService->createNode(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone
                ],
                $request->sponsor_id,
                $request->preferred_position
            );

            return apiResponse(true, 'Member Registered successfully!', [
                'member_number' => $result['node']->member_number,
                'temporary_password' => $result['password']
            ], 200);
        } catch (\Exception $e) {
            return apiResponse(false, 'An error occurred while adding the member.', $e->getMessage(), 500);
        }
    }

    public function forget_password(Request $request, SMSService $smsService){
        $validator = Validator::make($request->all(), [
            'phone' => 'required|digits:10|regex:/^[6789]/|exists:users,phone',
            // 'password' => 'required|min:4',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => "false",'errors' => $validator->errors()], 422);
        }else{
            // in first version
            // Cookie::queue('user_phone', $r->phone, 5);
            // return $this->forget_password($r->phone);

            // in second version date - 30-12-2024
            $user = User::where('phone',$request->phone)->first();
            $responce = $smsService->sendSMS('91'.$user->phone,$user->binaryNode->member_number,$user->decoded_password);
            // return $responce;
            if(!empty($responce)){
                if($responce['statusCode'] == 200){
                    return response()->json([
                        'status' => "true",
                        'message' => 'Password reset successfully. We have sent an SMS to your phone number. Please check it.',
                    ], 200);
                }else{
                    return response()->json([
                        'status' => "false",
                        'message' => "An internal issue occurred. If you didn't receive any message, please try again.",
                    ], 200);
                }
            }else{
                return response()->json([
                    'status' => "false",
                    'message' => "An internal issue occurred. If you didn't receive any message, please try again.",
                ], 200);
            }
        }
    }
}
