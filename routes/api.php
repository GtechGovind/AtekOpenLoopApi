<?php

use App\Http\Controllers\Module\Auth\AuthController;
use App\Http\Controllers\Module\Issuance\CardController;
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

/*
 * CARD ISSUANCE
 */
Route::post('/card/issue',[CardController::class,'issueCard']);

