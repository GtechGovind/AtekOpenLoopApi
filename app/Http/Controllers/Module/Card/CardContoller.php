<?php

namespace App\Http\Controllers\Module\Card;

use App\Http\Controllers\Controller;
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
           'is_issued'   => env('NoIssued')
        ]);

        return response ([
           'success' => true,
           'message' => 'Card data inserted successfully'
        ]);
    }
}
