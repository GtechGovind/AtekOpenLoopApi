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
            'card_no' => 'required',
            'amount' => 'required'
        ]);

        if (!AuthController::isSessionValid($data['session_token'])) return response([
            'success' => false,
            'message' => 'Something went wrong !',
            'code' => env('SESSION_EXPIRED_ERROR_CODE'),
            'errors' => [
                'session' => [
                    "Session is expired !"
                ]
            ]
        ]);

        $UserExist = DB::table('cust_card_info')
            ->where('cust_id','=',$request->input('cust_id'))
            ->orderBy('cust_card_info_id','desc')
            ->first();


        if(is_null($UserExist))
        {

            $cust_kyc_type = DB::table('cust_kyc_infos')
                ->where('cust_id','=',$request->input('cust_id'))
                ->first();
            $card_fee = DB::table('card_inv')
                ->where('card_no','=',$request->input('card_no'))
                ->first();
            if($cust_kyc_type->kyc_type_id == env('MinKyc')){
                DB::table('cust_card_info')->insert([
                    'cust_id' => $request->input('cust_id'),
                    'card_no' => $request->input('card_no'),
                    'card_fee' => $card_fee->card_fee,
                    'is_blocked'=>false,
                    'acc_balance' => $request->input('amount'),
                    'total_balance' => $request ->input('amount'),
                    'monthly_recharge'=>$request->input('amount'),
                    'eligible_limit' => env('MinAmount')
                ]);

                DB::table('cust_tnx')->insert([
                    'cust_id'=>$request->input('cust_id'),
                    'tnx_type_id'=>env('CREDIT'),
                    'tnx_amount' => $request->input('amount')
                ]);

                DB::table('block_wal')
                    ->where('cust_id','=',$request->input('cust_id'))
                    ->update([
                        'is_settle'=>true
                    ]);

                return response([
                    'success'=>true,
                    'code' => env('SESSION_EXPIRED_ERROR_CODE'),
                    'Message' => 'Recharged successfully'
                ]);
            }

            DB::table('cust_card_info')->insert([
                'cust_id' => $request->input('cust_id'),
                'card_no' => $request->input('card_no'),
                'card_fee' => $card_fee->card_fee,
                'is_blocked'=>false,
                'acc_balance' => $request->input('amount'),
                'total_balance' => $request ->input('amount'),
                'monthly_recharge'=>$request->input('amount'),
                'eligible_limit' => env('MaxAmount')
            ]);

            DB::table('cust_tnx')->insert([
                'cust_id'=>$request->input('cust_id'),
                'tnx_type_id'=>env('CREDIT'),
                'tnx_amount' => $request->input('amount')
            ]);


            DB::table('block_wal')
                ->where('cust_id','=',$request->input('cust_id'))
                ->update([
                    'is_settle'=>true
                ]);

            return response([
                'success'=>true,
                'code' => env('RECHARGE_SUCCESSFULLY_CODE'),
                'Message' => 'Recharged successfully'
            ]);

        }else{
            $amt = $request->input('amount');
            $AccBalance= $UserExist->acc_balance - $amt;
            $chipAmount = $UserExist->chip_balance + $amt;
            $monthlyBalance = $UserExist->monthly_recharge + $amt;
            if($monthlyBalance >= $UserExist->eligible_limit){
                return response([
                    'success'=> false,
                    'code' => env('USER_REACHED_ELIGIBLE_LIMIT'),
                    'message' => 'User reached to Eligile Limit'
                ]);
            }
            DB::table('cust_card_info')
                ->where('cust_id','=',$UserExist->cust_id)
                ->orderBy('cust_card_info_id','desc')
                ->update([
                    'acc_balance'=>$AccBalance,
                    'chip_balance' => $chipAmount,
                    'monthly_recharge' => $monthlyBalance
                ]);
            DB::table('cust_tnx')->insert([
                'cust_id'=>$UserExist->cust_id,
                'tnx_type_id'=>env('CREDIT'),
                'tnx_amount' => $amt
            ]);

            return response([
                'success' => true,
                'code' => env('AMOUNT_UPDATE_SUCCESS_CODE'),
                'message' => 'Amount updated successfully'
            ]);
        }
    }

    //Update Balance from Account to Chip
    public function updateBalance(Request $request){
        $request->validate([
            'card_no' => 'required|min:4|max:4',
            'amount' => 'required'
        ]);

        $user_acc = DB::table('cust_card_info')
            ->where('card_no','=',$request->input('card_no'))
            ->first();

        if(is_null($user_acc)){
            return response([
                'success'=> false,
                'code' => env('INVALID_CARD_NUMBER_CODE'),
                'error' => 'Invalid card number, card not found'
            ]);

        }else{
            $amt = $request->input('amount');
            $AccBalance= $user_acc->acc_balance - $amt;
            $chipAmount = $user_acc->chip_balance + $amt;
            $monthlyBalance = $user_acc->monthly_recharge + $amt;
            if($monthlyBalance >= $user_acc->eligible_limit){
                return response([
                    'success'=> false,
                    'code' => env('USER_REACHED_ELIGIBLE_LIMIT'),
                    'message' => 'User reached to Eligile Limit'
                ]);
            }

            DB::table('cust_card_info')
                ->where('card_no','=',$user_acc->card_no)
                ->orderBy('cust_card_info_id','desc')
                ->update([
                    'acc_balance'=>$AccBalance,
                    'chip_balance' => $chipAmount,
                    'monthly_recharge' => $monthlyBalance
                ]);
            DB::table('cust_tnx')->insert([
                'cust_id'=>$user_acc->cust_id,
                'tnx_type_id'=>env('CREDIT'),
                'tnx_amount' => $amt
            ]);

            return response([
                'success' => true,
                'code' => env('AMOUNT_UPDATE_SUCCESS_CODE'),
                'message' => 'Amount updated successfully'
            ]);
        }

    }

    //Update Chip Balance by Cash
    public function moneyLoad(Request $request){
        $request->validate([
            'card_no' => 'required|min:4|max:4',
            'amount' => 'required'
        ]);

        $user_acc = DB::table('cust_card_info')
            ->where('card_no','=',$request->input('card_no'))
            ->first();

        if(is_null($user_acc)){
            return response([
                'success'=> false,
                'code' => env('INVALID_CARD_NUMBER_CODE'),
                'error' => 'Invalid card number, card not found'
            ]);

        }else{
            $amt = $request->input('amount');
            $chipAmount = $user_acc->chip_balance + $amt;
            $monthlyBalance = $user_acc->monthly_recharge + $amt;
            $total_balance = $user_acc->acc_balance + $chipAmount;
            if($monthlyBalance >= $user_acc->eligible_limit){
                return response([
                    'success'=> false,
                    'code' => env('USER_REACHED_ELIGIBLE_LIMIT'),
                    'message' => 'User reached to Eligile Limit'
                ]);
            }

            DB::table('cust_card_info')
                ->where('card_no','=',$user_acc->card_no)
                ->orderBy('cust_card_info_id','desc')
                ->update([

                    'chip_balance' => $chipAmount,
                    'monthly_recharge' => $monthlyBalance
                ]);
            DB::table('cust_tnx')->insert([
                'cust_id'=>$user_acc->cust_id,
                'tnx_type_id'=>env('CREDIT'),
                'tnx_amount' => $amt
            ]);

            return response([
                'success' => true,
                'code' => env('AMOUNT_UPDATE_SUCCESS_CODE'),
                'message' => 'chip balance updated successfully'
            ]);

        }

    }

    //Update Account Balance
    public function updateAccBalance(Request $request){
        $request->validate([
            'card_no'=> 'required|min:4|max:4',
            'amount' => 'required'
        ]);

        $user_acc = DB::table('cust_card_info')
            ->where('card_no','=',$request->input('card_no'))
            ->first();

        if(is_null($user_acc)){
            return response([
                'success'=> false,
                'code' => env('INVALID_CARD_NUMBER_CODE'),
                'error' => 'Invalid card number, card not found'
            ]);

        }else{
            $amt = $request->input('amount');
            $AccBalance= $user_acc->acc_balance + $amt;
            $total_balance = $user_acc->chip_balance + $AccBalance;

            DB::table('cust_card_info')
                ->where('card_no','=',$user_acc->card_no)
                ->orderBy('cust_card_info_id','desc')
                ->update([

                    'acc_balance' => $AccBalance,
                    'total_balance' => $total_balance
                ]);
            DB::table('cust_tnx')->insert([
                'cust_id'=>$user_acc->cust_id,
                'tnx_type_id'=>env('CREDIT'),
                'tnx_amount' => $amt
            ]);

            return response([
                'success' => true,
                'code' => env('AMOUNT_UPDATE_SUCCESS_CODE'),
                'message' => 'Account balance updated successfully'
            ]);

        }

    }
}
