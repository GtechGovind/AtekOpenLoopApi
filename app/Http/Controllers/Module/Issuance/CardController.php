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
            'card_pan_no' => 'required|max:16|min:16'
        ]);

        AuthController::isSessionValid($data['session_token']);

        $cardData = $this->getCardData($data['card_pan_no']);

        if ($cardData) {

            $issueCard = new IssueCard();
            $issueCard->cust_id = $data['cust_id'];
            $issueCard->card_pan_no = $data['card_pan_no'];
            $issueCard->card_cvv_no = $cardData->card_cvv_no;
            $issueCard->card_expiry = Carbon::create(now())->addYears(5);
            $issueCard->is_blocked = false;
            $issueCard->save();

            return response([
                'success' => true,
            ]);

        }

        return response([
            'success' => false,
            'message' => 'Something went wrong !',
            'errors' => [
                'otp' => [
                    "Invalid request, no data found !"
                ]
            ]
        ]);

    }

    private function getCardData($card_pan_no)
    {
        $card_data = CardInventory::where('card_pan_no', $card_pan_no)
            ->where('is_issued', true)
            ->first();

        if (is_null($card_data)) return false;
        else return $card_data;

    }

}
