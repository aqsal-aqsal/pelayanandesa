<?php

class FonnteHelper {
    public static function send($target, $message) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
            'target' => $target,
            'message' => $message,
            'countryCode' => '62', // Default Indonesia
          ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: ' . FONNTE_TOKEN
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
