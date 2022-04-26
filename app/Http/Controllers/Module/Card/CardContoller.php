<?php

namespace App\Http\Controllers\Module\Card;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardContoller extends Controller
{
    public function insertCardData(Request $request){
        $request ->validate([
           'card_pan_no' => 'required',
           'card_cvv_no' => 'required'
        ]);

        DB::table('card_inventories')->insert([
           'card_pan_no' => $request->input('card_pan_no'),
           'card_cvv_no' => $request->input('card_cvv_no'),
           'is_issued'   => env('NotIssued')
        ]);

        return response ([
           'success' => true,
           'message' => 'Card data inserted successfully'
        ]);
    }

    //Issue Card

    public function issueCard(Request $request){
        $request ->validate([
           'cust_id' => 'required'
        ]);
        $time = Carbon::now();
        $currentTime = $time->toDateTimeString();
        $cardExpiryDate = $time->addYears(3);
       $mobile_no = DB::table('cust_kyc_infos')
           ->where('cust_id','=',$request->input('cust_id'))
           ->first();
       $session = DB::table('user_sessions')
                ->where('mobile_no','=',$mobile_no->mobile_no)
                ->orderBy('user_session_id','desc')
                ->first();
       if($currentTime <= $session->session_expires_at){
           $getCard = DB::table('card_inventories')
                    ->where('is_issued','=',env('NotIssued'))
                    ->first();
           DB::table('issue_cards')->insert([
              'cust_id' => $request->input('cust_id'),
              'card_pan_no' => $getCard->card_pan_no,
              'card_cvv_no' => $getCard->card_cvv_no,
              'card_expiry' =>  $cardExpiryDate,
               'is_blocked' => env('NotBlocked')
           ]);

           DB::table('card_inventories')
               ->where('card_pan_no','=',$getCard->card_pan_no)
               ->update([
                  'is_issued' => env('Issued')
               ]);

           $cardDetails = DB::table('issue_cards')
                        ->where('cust_id','=',$request->input('cust_id'))
                        ->first();
           return response([
              'success' => true,
              'card_data'=>$cardDetails
           ]);

       }else{
           return response([
              'success' => false,
              'error' =>'Session expired, generate OTP again!'
           ]);
       }

    }
}
