<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function runAPI(){
        $cityAPI = $this->cityAPI();
        $googleAPI = $this->googleAPI();

        return view('API')->with('arrayAPI',[$cityAPI, $googleAPI]);
    }

    public function cityAPI(){

        $client = new Client();

        $response = $client->request('GET', 'https://weatherapi-com.p.rapidapi.com/forecast.json?q=Surabaya&days=3', [
            'headers' => [
            'X-RapidAPI-Key' => 'f1193e4665mshcc9064726e7e81fp1ac665jsn438234adb9fb',
            'X-RapidAPI-Host' => 'weatherapi-com.p.rapidapi.com'
            ]
        ]);
        $data = json_decode((string) $response->getBody(),true);

        return $data;
    }

    public function googleAPI(){

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://google-search3.p.rapidapi.com/api/v1/search/q=laravel",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-Proxy-Location: SG",
                "X-RapidAPI-Host: google-search3.p.rapidapi.com",
                "X-RapidAPI-Key: b91eebc376msh977f86a62628d2dp1d9d2fjsnf90532decf15",
                "X-User-Agent: desktop"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response);
            return $data;
        }
    }
}
