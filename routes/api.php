<?php

use App\Http\Controllers\Module\Auth\AuthController;
use App\Http\Controllers\Module\Kyc\KycController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 * USER AUTHORIZATION
*/
Route::post('/auth', [AuthController::class, 'sendOtp']);
Route::post('/validate', [AuthController::class, 'validateOtp']);

/*
 * USER KYC
*/
Route::post('/kyc/check', [KycController::class, 'checkUserKyc']);
Route::post('/kyc', [KycController::class, 'kycUser']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Card Issuence
Route::post('/card/insert',[\App\Http\Controllers\Module\Card\CardContoller::class,'insertCardData']);

Route::post('/card/issue',[\App\Http\Controllers\Module\Card\CardContoller::class,'issueCard']);
