<?php

namespace App\Http\Controllers;

use GuzzleHttp;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function show_product(){
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', 'https://reqres.in/api/users?page=1', [
            'auth' => ''
        ]);
        $products = json_decode((string) $res->getBody(),true);

        return view('API')->with('products',$products);
    }

    public function add_product()
    {
        // URL
        $apiURL = 'https://reqres.in/api/users?page=1';

       // POST Data
        $postInput = [
            'id' => '101',
            'first_name' => "First",
            'last_name' => "Last",
            'email' => "FL@gmail.com"
        ];

        // Headers
        $headers = [
            //...
            'Content-Type:application/json'
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $apiURL, ['form_params' => $postInput, 'headers' => $headers]);

        $responseBody = json_decode($response->getBody(), true);

        echo $statusCode = $response->getStatusCode(); // status code

        // $response = $response->getBody()->getContents();
        // echo '<pre>';
        // print_r($response);
        dd($responseBody); // body response
    }
    // public function store(Request $request)
    // {
    //     $data = new GuzzlePost();
    //     $data->name=$request->get('name');
    //     $data->save();
    //     return response()->json('Successfully added');

    // }
    public function update()
    {

        $client = new GuzzleHttp\Client();
        $apiURL = 'https://reqres.in/api/users?page=1';
        $UpdateInput = [
            'id' => '101',
            'first_name' => "unknown",
            'last_name' => "person",
            'email' => "unknown@gmail.com"
        ];
        $response = $client->request('PUT', $apiURL, ['form_params' => $UpdateInput]);
        $Upt = json_decode((string) $response->getBody(),true);
        dd($Upt);
        return view('API')->with('Upt',$Upt);
        // return Redirect::route('locations.show', Input::get('id'));
    }

    public function delete($uri)
    {
        try {
            $this->httpClient->delete($uri)->send();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return true;
    }
}
