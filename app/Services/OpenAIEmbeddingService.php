<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenAIEmbeddingService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.openai.key'),
                'Content-Type'  => 'application/json',
            ],
            'timeout' => 30,
        ]);
    }

    public function embed(string $text): array
    {
        $response = $this->client->post('embeddings', [
            'json' => [
                'model' => 'text-embedding-3-small',
                'input' => $text,
            ],
        ]);

        return json_decode($response->getBody(), true)['data'][0]['embedding'];
    }
}

?>