<?php

namespace App\Http\Controllers\Module\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Module\Message\SendMessageController;
use App\Models\UserSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Client\ClientExceptionInterface;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class AuthController extends Controller
{

    function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|min:10|max:10',
            'message_media' => 'required|min:1|max:2'
        ]);

        if ($validator->fails()) {
            return response([
                'success' => false,
                'code' => env('VALIDATION_ERROR_CODE'),
                'error' => $validator->errors()
            ]);
        }

        $mobile_number = $request->input('mobile_no');
        $otp = rand(111111, 999999);

        $user_session = new UserSession();
        $user_session->mobile_no = $mobile_number;
        $user_session->otp = $otp;
        $user_session->otp_created_at = Carbon::now();
        $user_session->otp_expires_at = Carbon::create(now())->addMinutes(5);
        $user_session->save();

        if ($request->input('message_media') == 1) SendMessageController::sendSms($mobile_number, $otp);
        else SendMessageController::sendWhatsAppMessage($mobile_number, $otp);

        return response([
            'success' => true,
            'code' => env('OTP_SENT_SUCCESSFULLY_CODE'),
            'message' => "OTP sent successfully",
        ]);

    }

    function validateOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|min:6|max:6'
        ]);

        if ($validator->fails()) {
            return response([
                'success' => false,
                'code' => env('VALIDATION_ERROR_CODE'),
                'error' => $validator->errors()
            ]);
        }

        $otp = $request->input('otp');

        $user_session = UserSession::where('otp', $otp)->first();

        if (is_null($user_session)) return response([
            'success' => false,
            'code' => env('WRONG_OTP_ERROR_CODE'),
            'error' => "Invalid OTP, please check OTP again !"
        ]);

        if (Carbon::create($user_session->otp_expires_at)->timestamp < Carbon::now()->timestamp) return response([
            'success' => false,
            'code' => env('OTP_EXPIRED_ERROR'),
            'error' => "OTP expired, please send OTP again !"
        ]);

        $user_session->session_token = hash(
            'sha1',
            $user_session->mobile_no + $user_session->otp + Carbon::now()->timestamp
        );

        $user_session->session_created_at = Carbon::now();
        $user_session->session_expires_at = Carbon::now()->addMinutes(25);
        $user_session->save();

        $userKycInfo =  DB::table('cust_kyc_infos')
            ->where('mobile_no', '=',$user_session->mobile_no)
            ->first();

        if(!is_null($userKycInfo)) {

            $card_info = DB::table('cust_card_info')
                ->where('cust_id', '=', $userKycInfo->cust_id)
                ->first();

            if (!is_null($card_info)) {
                return response([
                    'success' => false,
                    'code' => env('USER_ALREADY_HAS_CARD_CODE'),
                    'session_token' => $user_session->session_token,
                    'card_details' => $card_info
                ]);
            }
        }

        return response([
            'success' => true,
            'code' => env('OTP_VERIFIED_SUCCESSFULLY'),
            'message' => 'User Kyc not registered',
            'session_token' => $user_session->session_token
        ]);

    }

    static function isSessionValid($session_token)
    {
        $user_data = UserSession::where('session_token', $session_token)

            ->first();

        if(is_null($user_data)){
            return false;
        }else{
          $expire = $user_data->session_expires_at;
            $time = Carbon::now();
            $currentTime = $time->toDateTimeString();
            if($currentTime <= $expire){
                return true;
            }else{
                return false;
            }
        }


    }

}
