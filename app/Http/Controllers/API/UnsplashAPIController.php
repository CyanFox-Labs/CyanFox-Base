<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class UnsplashAPIController extends Controller
{

    public function getRandomUnsplashImage() {
        $api_key = env('UNSPLASH_API_KEY');

        $client = new \GuzzleHttp\Client();

        $headers = [
            "Authorization" => "Client-ID $api_key"
        ];

        $response = $client->request('GET', 'https://api.unsplash.com/photos/random?query=landscape,beautiful', ['headers' => $headers]);

        return $response->getBody();
    }

}
