<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class ApiZapito extends Model
{
    use HasFactory;

    private static $url = "https://zapito.com.br/api/messages";

    public static function sendMessage($phone, $message, $test = true, $check_phone = true)
    {
        
        $data = [
            "test_mode" => $test,
            "data" => [
                "phone" => $phone,
                "message" => $message,
                "test" => $test,
                "check_phone" => $check_phone
            ]
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://zapito.com.br/api/messages');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer '.env('API_ZAPITO_TOKEN');

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        var_dump(json_decode($result));

        return $result;
    }
}
