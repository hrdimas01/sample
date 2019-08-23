<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Firebase extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public static function send($device_token, $content)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $field = array(
            'registration_ids' => $device_token,
            'data' => $content
        );

        $headers = array(
            'Authorization:key = FIREBASE_APP_KEY',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($field));

        $result = curl_exec($ch);
        if($result === FALSE){
            die('Curl failde: '. curl_error($ch));
        }

        curl_close($ch);
        return $result;
    }
}
