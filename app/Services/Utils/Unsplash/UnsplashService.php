<?php

namespace App\Services\Utils\Unsplash;

use Exception;
use GuzzleHttp\Client;

class UnsplashService
{
    public function returnBackground(): array
    {
        try {
            $imageData = self::getRandomUnsplashImage();
            $utmSource = self::getUTM();

            $imagePath = $imageData[0]['urls']['regular'];
            $photoLink = $imageData[0]['links']['html'].$utmSource;
            $authorName = $imageData[0]['user']['name'];
            $authorLink = $imageData[0]['user']['links']['html'].$utmSource;
            $error = null;

            $css = "background-image: url('".$imagePath."');
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center;
                    background-attachment: fixed;
                    background-color: #000000;
                    filter: blur(5px);
                    opacity: 0.5";
        } catch (Exception $e) {
            $css = 'background: rgb(2,0,36);
                    background: linear-gradient(310deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 0%, rgba(0,212,255,1) 100%);';

            $error = $e->getMessage();
            $photoLink = null;
            $authorName = null;
            $authorLink = null;
        }

        return [
            'css' => $css,
            'error' => $error,
            'photo' => $photoLink,
            'author' => $authorName,
            'authorURL' => $authorLink,
        ];
    }

    public function getUTM(): ?string
    {
        return setting('unsplash_utm');
    }

    public function getRandomUnsplashImage(): array
    {
        $api_key = setting('unsplash_api_key', true);
        if ($api_key == null || $api_key == '') {
            $api_key = config('template.unsplash.api_key');
        }

        $client = new Client;

        $headers = [
            'Authorization' => "Client-ID $api_key",
        ];

        $response = $client->request('GET', 'https://api.unsplash.com/photos/random?count=1&query=landscape,beautiful', ['headers' => $headers]);

        return json_decode((string) $response->getBody(), true);
    }
}
