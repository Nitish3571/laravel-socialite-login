<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Exception;
use Twilio\Rest\Client;
class UserOtp extends Model
{

    protected $fillable = [
        'user_id',
        'otp',
        'expaired_at',
    ];

    public function sendSMS($recieverNumber){
        $message = 'Login OTP is '. $this->otp;

        try{

            $account_id = getenv('TWILIO_SID');
            $auth_token = getenv('TWILIO_AUTH_TOKEN');
            $twilio_no = getenv('TWILIO_NUMBER');

            $client = new Client($account_id, $auth_token);

            $client->messages->create($recieverNumber, [
                'from' => $twilio_no,
                'body' => $message,
            ]);

            \info('Sent Successfully');
        } catch(\Exception $e) {
            \info('Error');
            \info($e->getMessage());
        }
    }
}
