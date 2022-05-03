<?php

namespace App\Http\Controllers\Module\Kyc;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Module\Auth\AuthController;
use App\Models\CustKycInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KycController extends Controller
{
    function checkUserKyc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|min:10|max:10',
            'session_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'success' => false,
                'code' => env('VALIDATION_ERROR_CODE'),
                'error' => $validator->errors()
            ]);
        }

        if (!AuthController::isSessionValid($validator['session_token'])) return response([
            'success' => false,
            'code' => env('SESSION_EXPIRED_ERROR_CODE'),
            'error' => 'Session expired please verify user again !'
        ]);

        $mobile_no = $request->input('mobile_no');
        $user_kyc = CustKycInfo::where('mobile_no', $mobile_no)->first();

        if (is_null($user_kyc)) return response([
            'success' => true,
            'code' => env('USER_DOES_NOT_HAVE_KYC_CODE'),
            'message' => "User don't have kyc with bank."
        ]);

        return response([
            'success' => true,
            'code' => env('USER_HAVE_KYC_CODE'),
            'message' => "User already have kyc",
            'cust_id' => $user_kyc->cust_id
        ]);

    }

    function kycUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:1|max:30',
            'middle_name' => 'required|min:1|max:30',
            'last_name' => 'required|min:1|max:30',
            'gender' => 'required|min:1|max:3',
            'mobile_no' => 'required|min:10|max:10|unique:cust_kyc_infos',
            'date_of_birth' => 'required',
            'kyc_type_id' => 'required',
            'ovd_type_id' => 'required',
            'ovd_no' => 'required|unique:cust_kyc_infos',
            'session_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'success' => false,
                'code' => env('VALIDATION_ERROR_CODE'),
                'error' => $validator->errors()
            ]);
        }

        if (!AuthController::isSessionValid($validator['session_token'])) return response([
            'success' => false,
            'code' => env('SESSION_EXPIRED_ERROR_CODE'),
            'error' => 'Session expired please verify user again !'
        ]);

        $user_kyc = new CustKycInfo();
        $user_kyc->create($validator);

        return response([
            'success' => true,
            'code' => env('SUCCESSFUL_KYC_CODE'),
            'message' => "Kyc successful.",
            'cust_id' => CustKycInfo::where('mobile_no', $validator['mobile_no'])->first()->cust_id
        ]);

    }

}
