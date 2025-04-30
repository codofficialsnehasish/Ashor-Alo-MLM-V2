<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\{
    AuthController,
};

Route::post('/login', [AuthController::class, 'login']);
Route::post('/get-sponsor-name', [AuthController::class, 'getSponsorName']);


Route::middleware('auth:sanctum')->group( function () {

});