<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Address;
use App\Models\BankDetail;
use App\Models\Nominee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserProfileController extends Controller
{
    /**
     * Get complete user profile with all related data
     */
    public function get_profile(Request $request)
    {
        try {
            $user = User::findOrFail($request->user()->id);

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'profile' => $user->profile ?? null,
                    'address' => $user->address ?? null,
                    'bank_details' => $user->bankDetails ?? null,
                    'nominee' => $user->nominee ?? null,
                    'profile_image_url' => $user->getFirstMediaUrl('profile-image') ?? null
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User profile not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update basic profile details
     */
    public function update_profile_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'father_or_husband_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'marital_status' => 'required|string|in:single,married,divorced,widowed',
            'qualification' => 'nullable|string',
            'occupation' => 'nullable|string',
            'pan_number' => 'nullable'
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', ['error' => $validator->errors()], 422);
        }

        try {
            UserProfile::updateOrCreate(
                ['user_id' => $request->user()->id],
                $request->all()
            );

            return apiResponse(true, 'Profile details updated successfully', ['profile' => UserProfile::where('user_id', $request->user()->id)->first()], 200);
        } catch (\Exception $e) {
            return apiResponse(false, 'Failed to update profile details', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update profile picture  
     */
    public function update_profile_picture(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_image' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', ['error' => $validator->errors()], 422);
        }

        try {
            $user = User::findOrFail($request->user()->id);
            
            $user->clearMediaCollection('profile-image');

            $user->addMediaFromBase64($request->profile_image)
                ->usingFileName(Str::random(10) . '.png')
                ->toMediaCollection('profile-image');

            return apiResponse(true, 'Profile picture updated successfully.', ['profile_image_url' => $user->getFirstMediaUrl('profile-image')], 200);
        } catch (\Exception $e) {
            return apiResponse(false, 'Failed to update profile picture.', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update address details
     */
    public function update_address_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_address' => 'required|string',
            'country_id' => 'required|exists:location_countries,id',
            'address' => 'required|string',
            'state_id' => 'required|exists:location_states,id',
            'city_id' => 'required|exists:location_cities,id',
            'pin_code' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', ['error' => $validator->errors()], 422);
        }

        try {
            Address::updateOrCreate(
                ['user_id' => $request->user()->id],
                $request->all()
            );

            return apiResponse(true, 'Address details updated successfully', ['address' => Address::where('user_id', $request->user()->id)->first()], 200);
        } catch (\Exception $e) {
            return apiResponse(false, 'Failed to update address details', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update bank details
     */
    public function update_bank_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:20',
            'account_number' => 'required|string|max:30',
            'account_type' => 'required|string|in:Saving,Current',
            'upi_name' => 'nullable|string|max:255',
            'upi_number' => 'nullable|string|max:255',
            'upi_type' => 'nullable|string|in:Phone Pay,Google Pay,Paytm',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', ['error' => $validator->errors()], 422);
        }

        try {
            BankDetail::updateOrCreate(
                ['user_id' => $request->user()->id],
                $request->all()
            );

            return apiResponse(true, 'Bank details updated successfully', ['bank_detail' => BankDetail::where('user_id', $request->user()->id)->first()], 200);
        } catch (\Exception $e) {
            return apiResponse(false, 'Failed to update bank details', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update nominee details
     */
    public function update_nominee_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nominee_name' => 'required|string|max:255',
            'nominee_relation' => 'required|string|max:100',
            'nominee_dob' => 'required|date',
            'nominee_address' => 'required|string',
            'nominee_state_id' => 'required|exists:location_states,id',
            'nominee_city_id' => 'required|exists:location_cities,id',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', ['error' => $validator->errors()], 422);
        }

        try {
            Nominee::updateOrCreate(
                ['user_id' => $request->user()->id],
                $request->all()
            );

            return apiResponse(true, 'Nominee details updated successfully', ['nominee' => Nominee::where('user_id', $request->user()->id)->first()], 200);
        } catch (\Exception $e) {
            return apiResponse(false, 'Failed to update nominee details', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Change password
     */
    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', ['error' => $validator->errors()], 422);
        }

        try {
            $user = User::findOrFail($request->user()->id);

            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return apiResponse(false, 'Current password is incorrect', null, 401);
            }

            // Update password
            $user->password = Hash::make($request->new_password);
            $user->decoded_password = $request->new_password;
            $user->update();

            return apiResponse(true, 'Password changed successfully', null, 200);
        } catch (\Exception $e) {
            return apiResponse(false, 'Failed to change password', ['error' => $e->getMessage()], 500);
        }
    }
}