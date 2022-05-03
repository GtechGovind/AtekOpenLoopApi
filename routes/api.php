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


/*
 * Account Maintaing
 */

Route::post('/card/recharge',[\App\Http\Controllers\Module\AccountMaintaing\CustAccController::class,'RechargeCard']);

Route::post('/card/update/balance',[\App\Http\Controllers\Module\AccountMaintaing\CustAccController::class,'updateBalance']);
Route::post('/card/money/load',[\App\Http\Controllers\Module\AccountMaintaing\CustAccController::class,'moneyLoad']);
Route::post('/card/updateacc/balance',[\App\Http\Controllers\Module\AccountMaintaing\CustAccController::class,'updateAccBalance']);
