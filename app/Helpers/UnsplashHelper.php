<?php

namespace App\Helpers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class UnsplashHelper
{

    public static function returnBackground()
    {
        try {
            $imageData = self::getRandomUnsplashImage();
            $utmSource = self::getUTM();

            $imagePath = $imageData[0]['urls']['regular'];
            $photoLink = $imageData[0]['links']['html'] . $utmSource;
            $authorName = $imageData[0]['user']['name'];
            $authorLink = $imageData[0]['user']['links']['html'] . $utmSource;
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
            $css = "background: rgb(2,0,36);
                    background: linear-gradient(310deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 0%, rgba(0,212,255,1) 100%);";

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
            'authorURL' => $authorLink
        ];
    }

    public static function getUTM()
    {
        return setting('unsplash_utm', '?utm_source=your_app_name&utm_medium=referral');
    }

    /**
     * @throws GuzzleException
     */
    public static function getRandomUnsplashImage() {
        $api_key = setting('unsplash_api_key', true);

        $client = new Client();

        $headers = [
            "Authorization" => "Client-ID $api_key"
        ];

        $response = $client->request('GET', 'https://api.unsplash.com/photos/random?count=1&query=landscape,beautiful', ['headers' => $headers]);
        return json_decode((string) $response->getBody(), true);
    }
}