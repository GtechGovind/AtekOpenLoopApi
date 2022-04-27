<?php

namespace App\Http\Controllers\Module\AccountMaintaing;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Module\Auth\AuthController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustAccController extends Controller
{
    public function RechargeCard(Request $request){
          $data = $request->validate([
               'cust_id' => 'required',
               'session_token' => 'required',
                'amount' => 'required|min:100'
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

        $UserExist = DB::table('cust_balances')
                    ->where('cust_id','=',$request->input('cust_id'))
                    ->orderBy('cust_balance_id','desc')
                    ->first();


        if(is_null($UserExist))
        {

            $cust_kyc_type = DB::table('cust_kyc_infos')
                ->where('cust_id','=',$request->input('cust_id'))
                ->first();
            if($cust_kyc_type->kyc_type_id == env('MinKyc')){
                DB::table('cust_balances')->insert([
                    'cust_id' => $request->input('cust_id'),
                    'acc_balance' => $request->input('amount'),
                    'chip_balance' => $request->input('amount'),
                    'total_balance' => $request ->input('amount'),
                    'eligible_limit' => env('MinAmount')
                ]);

                return response([
                    'success'=>true,
                    'Message' => 'Recharged successfully'
                ]);
            }

            DB::table('cust_balances')->insert([
                'cust_id' => $request->input('cust_id'),
                'acc_balance' => $request->input('amount'),
                'chip_balance' => $request->input('amount'),
                'total_balance' => $request ->input('amount'),
                'eligible_limit' => env('MaxAmount')
            ]);
        }else{
            $amt = $request->input('amount');
           $currentAmount= $UserExist->total_balance + $amt;
            DB::table('cust_balances')
                ->where('cust_id','=',$UserExist->cust_id)
                ->orderBy('cust_balance_id','desc')
                ->update([
                    'total_balance'=>$currentAmount
                ]);
            return response([
                'success' => true,
                'message' => 'Amount updated successfully'
            ]);
        }




    }
}
