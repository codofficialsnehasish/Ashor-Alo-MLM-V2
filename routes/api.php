<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\{
    AuthController,
    KYCController,
    LocationApiController,
    UserProfileController,
    Documents,
    BinaryTreeApiController,
    UserDashboardAPI,
    ReportAPIController,
};

Route::post('/login', [AuthController::class, 'login']);
Route::post('/get-sponsor-name', [AuthController::class, 'getSponsorName']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forget-password', [AuthController::class, 'forget_password']);

Route::prefix('locations')->group(function () {
    Route::get('/countries', [LocationApiController::class, 'getCountries']);
    Route::get('/states/{country_id?}', [LocationApiController::class, 'getStates']);
    Route::get('/cities/{state_id?}', [LocationApiController::class, 'getCities']);
});

Route::middleware('auth:sanctum')->group( function () {

    Route::get('/dashboard', [UserDashboardAPI::class, 'dashboard']);
    
    Route::get('/kyc-details', [KYCController::class, 'index']);
    Route::post('/kyc-upload', [KYCController::class, 'upload']);

    Route::prefix('user')->group(function () {
        // Get complete profile
        Route::get('/profile', [UserProfileController::class, 'get_profile']);
        
        // Update operations
        Route::post('/update-profile-details', [UserProfileController::class, 'update_profile_details']);
        Route::post('/update-profile-picture', [UserProfileController::class, 'update_profile_picture']);
        Route::post('/update-address-details', [UserProfileController::class, 'update_address_details']);
        Route::post('/update-bank-details', [UserProfileController::class, 'update_bank_details']);
        Route::post('/update-nominee-details', [UserProfileController::class, 'update_nominee_details']);
        Route::post('/change-password', [UserProfileController::class, 'change_password']);
    });

    Route::get('/welcome-letter', [Documents::class, 'welcome_letter']);
    Route::get('/id-card', [Documents::class, 'id_card']);

    Route::get('/direct', [BinaryTreeApiController::class, 'direct']);
    Route::get('/left-members', [BinaryTreeApiController::class, 'left_side_members']);
    Route::get('/right-members', [BinaryTreeApiController::class, 'right_side_members']);
    Route::get('/all-members', [BinaryTreeApiController::class, 'all_members']);
    Route::get('/tree-view/{rootId?}', [BinaryTreeApiController::class, 'getTree']);
    Route::get('/level-view', [BinaryTreeApiController::class, 'getTreeLevels']);

    Route::post('/topup-report', [ReportAPIController::class, 'topup_report']);
});