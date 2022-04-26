<?php

namespace App\Http\Controllers\Module\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Psr\Http\Client\ClientExceptionInterface;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class SendMessageController extends Controller
{
    public static function sendSms($mobile_no, $otp)
    {
        $basic = new Basic("5e8e86c8", "LjUle9urSav1reU7");
        $client = new Client($basic);

        try {
            $client->sms()->send(
                new SMS(
                    "91$mobile_no",
                    "AtekMetro",
                    "Your OTP for Mumbai Metro One Card is $otp"
                )
            );

        } catch (ClientExceptionInterface|Client\Exception\Exception $e) {
            return response([
                'success' => false,
                'message' => 'System error occurred !',
                'errors' => [
                    'otp' => [
                        $e->getMessage()
                    ]
                ]
            ]);
        }

    }

    public static function sendWhatsAppMessage($mobile_no, $otp)
    {
        Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic NWU4ZTg2Yzg6TGpVbGU5dXJTYXYxcmVVNw=='
        ])
            ->withBody('{
                "from": "14157386102",
                "to": "91' . $mobile_no . '",
                "message_type": "text",
                "text": "Your OTP for Mumbai Metro One Card is ' . $otp . '",
                "channel": "whatsapp"
              }', 'application/json')
            ->post('https://messages-sandbox.nexmo.com/v1/messages')
            ->collect();
    }

}
