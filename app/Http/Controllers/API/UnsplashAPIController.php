<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class UnsplashAPIController extends Controller
{

    public function getRandomUnsplashImage() {
        $api_key = env('UNSPLASH_API_KEY');

        $client = new Client();

        $headers = [
            "Authorization" => "Client-ID $api_key"
        ];

        $response = $client->request('GET', 'https://api.unsplash.com/photos/random?count=1&query=landscape,beautiful', ['headers' => $headers]);

        return $response->getBody();
    }

}
