<?php

namespace App\Helpers;

class Helper
{
    public static function sendSMS($mobile_no)
    {
        $from = "GROSTP";
        $to = $mobile_no;
        $otp = rand(1111, 9999);
        $message = str_replace("#OTP#", $otp, 'Hello Sir, Your generated otp is : #OTP#');
        $url = "http://sms.pearlsms.com/public/sms/send?sender=" . $from . "&smstype=TRANS&numbers=" . $to . "&apikey=be78ad749bbb4b2a9accde6e9413c104&message=" . urlencode($message);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        \Log::info('SMS Log');
        \Log::info($response);
        return $otp;
    }
}
