<?php

namespace App\Services\Utils;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class UnsplashService
{
    /**
     * Returns an array containing background-related information.
     *
     * This method attempts to retrieve a random image from Unsplash API and generates the necessary CSS styles
     * for displaying the image as a background. If successful, the array will contain the following keys:
     * - "css": The CSS styles for the background.
     * - "error": Set to null if no errors occurred, otherwise contains the error message.
     * - "photo": The link to the Unsplash photo page, with the UTM source appended.
     * - "author": The name of the photo's author.
     * - "authorURL": The link to the author's Unsplash profile, with the UTM source appended.
     * If an exception is caught during the process, the "error" key will contain the exception message,
     * and the other keys will be set to null.
     *
     * @return array An array containing background-related information.
     */
    public function returnBackground(): array
    {
        try {
            $imageData = self::getRandomUnsplashImage();
            $utmSource = self::getUTM();

            if ($imageData == null) {
                throw new Exception('Unsplash API key is not set.');
            }

            $imagePath = $imageData[0]['urls']['regular'];
            $photoLink = $imageData[0]['links']['html'] . $utmSource;
            $authorName = $imageData[0]['user']['name'];
            $authorLink = $imageData[0]['user']['links']['html'] . $utmSource;
            $error = null;

            $css = "background-image: url('" . $imagePath . "');
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center;
                    background-attachment: fixed;
                    background-color: #000000;
                    filter: blur(5px);
                    opacity: 0.5";
        } catch (Exception $e) {
            $css = setting('unsplash_fallback_css');

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

    /**
     * Retrieves the value of the UTM setting.
     *
     * @return string|null The value of the UTM setting, or null if it is not set.
     */
    public function getUTM(): ?string
    {
        return setting('unsplash_utm');
    }

    /**
     * Fetches a random image from the Unsplash API.
     *
     * @return array|null An array containing the random image details, or null if the API key is not set.
     *
     * @throws GuzzleException
     */
    public function getRandomUnsplashImage(): ?array
    {
        $api_key = setting('unsplash_api_key', true);
        if ($api_key == null || $api_key == '') {
            return null;
        }

        $client = new Client;

        $headers = [
            'Authorization' => "Client-ID $api_key",
        ];

        $response = $client->request('GET', 'https://api.unsplash.com/photos/random?count=1&query=landscape,beautiful', ['headers' => $headers]);

        return json_decode((string) $response->getBody(), true);
    }
}
