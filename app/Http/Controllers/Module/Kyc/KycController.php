<?php

namespace App\Http\Controllers\Module\Kyc;

use App\Http\Controllers\Controller;
use App\Models\CustKycInfo;
use Illuminate\Http\Request;

class KycController extends Controller
{
    function checkUserKyc(Request $request)
    {
        $request->validate([
            'mobile_no' => 'required|min:10|max:10'
        ]);

        $mobile_no = $request->input('mobile_no');
        $user_kyc = CustKycInfo::where('mobile_no', $mobile_no)->first();

        if (is_null($user_kyc)) return response([
            'success' => false,
            'message' => 'User does not have kyc!',
            'errors' => [
                'kyc' => [
                    "No KYC found for mobile number '$mobile_no'"
                ]
            ]
        ]);

        return response([
            'success' => true,
            'cust_id' => $user_kyc->cust_id
        ]);

    }

    function kycUser(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|min:4|max:30',
            'middle_name' => 'required|min:4|max:30',
            'last_name' => 'required|min:4|max:30',
            'mobile_no' => 'required|min:10|max:10|unique:cust_kyc_infos',
            'date_of_birth' => 'required',
            'kyc_type_id' => 'required',
            'ovd_type_id' => 'required',
            'ovd_no' => 'required|unique:cust_kyc_infos'
        ]);

        $user_kyc = new CustKycInfo();
        $user_kyc->create($data);

        return response([
            'success' => true,
            'cust_id' => CustKycInfo::where('mobile_no', $data['mobile_no'])->first()->cust_id
        ]);

    }

}
