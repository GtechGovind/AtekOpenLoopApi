<?php

namespace App\Http\Controllers\Module\Issuance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Module\Auth\AuthController;
use App\Models\CardInventory;
use App\Models\IssueCard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function insertCardData(Request $request)
    {
        $request->validate([
            'card_pan_no' => 'required',
            'card_cvv_no' => 'required'
        ]);

        DB::table('card_inventories')->insert([
            'card_pan_no' => $request->input('card_pan_no'),
            'card_cvv_no' => $request->input('card_cvv_no'),
            'is_issued' => env('NotIssued')
        ]);

        return response([
            'success' => true,
            'message' => 'Card data inserted successfully'
        ]);
    }

    public function issueCard(Request $request)
    {
        $data = $request->validate([
            'cust_id' => 'required',
            'session_token' => 'required',
            'card_no' => 'required|max:4|min:4',
            'amount' => 'required'

        ]);

        if (!AuthController::isSessionValid($data['session_token'])) return response([
            'success' => false,
            'message' => 'Something went wrong !',
            'errors' => [
                'session' => [
                    "Session is expired !"
                ]
            ]
        ]);

        $cardData = $this->getCardData($data['card_no']);

        if ($cardData) {

            $user_check = DB::table('cust_card_info')
                ->where('cust_id','=',$data['card_no'])
                ->first();

            if(!is_null($user_check)){
                return response([
                    'success' => false,
                    'error' => 'User already have a card'
                ]);
            }

            DB::table('card_inv')
                ->where('card_no','=',$data['card_no'])
                ->update([
                    'is_issued' => false
                ]);

            $user_exist = DB::table('block_wal')
                ->where('cust_id','=',$request->input('cust_id'))
                ->first();

            if(!is_null($user_exist)){
                return response([
                    'success'=>false,
                    'error' => 'User already issued card'
                ]);
            }

            DB::table('block_wal')->insert([
                'cust_id' => $request->input('cust_id'),
                'tnx_amount'=>$request ->input('amount'),
                'card_no'=>$request->input('card_no'),
                'is_settle' => false,
            ]);

            return response([
                'success'=> true,
                'cust_id'=>$request->input('cust_id'),
                'session_token'=>$request->input('session_token'),
                'card_no' => $request->input('card_no'),
                'message' => 'Recharge Pending.....'
            ]);
        }


        /*   return response([
               'success' => true,
               'cust_id' => $data['cust_id'],
               'session_token' => $data['session_token'],
               'card_info' => $cardData
           ]);*/



        return response([
            'success' => false,
            'message' => 'Something went wrong !',
            'errors' => [
                'card' => [
                    "Invalid request, no data found !"
                ]
            ]
        ]);

    }

    private function getCardData($card_no)
    {
        $card_data = DB::table('card_inv')
            ->where('card_no','=',$card_no)
            ->where('is_issued', true)
            ->first();

        if (is_null($card_data)) return false;
        else return $card_data;

    }



}
