<?php

namespace App\Services;

use GuzzleHttp\Client;

class FonnteService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.fonnte.api_key'); // Ensure you store your API key in the config/services.php file
    }

    public function sendMessage($phoneNumber, $message, $mediaUrl = null)
    {
        $url = 'https://api.fonnte.com/send';
        $payload = [
            'target' => $phoneNumber,
            'message' => $message,
            'url' => $mediaUrl,
        ];

        $headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
        ];

        $response = $this->client->post($url, [
            'headers' => $headers,
            'form_params' => $payload,
        ]);

        return json_decode($response->getBody(), true);
    }
}
