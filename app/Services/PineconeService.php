<?php

namespace App\Services;

use GuzzleHttp\Client;

class PineconeService
{
    protected Client $client;
    protected string $endpoint;

    public function __construct()
    {
        $this->endpoint = rtrim(config('services.pinecone.url'), '/');

        $this->client = new Client([
            'headers' => [
                'Api-Key'      => config('services.pinecone.key'),
                'Content-Type' => 'application/json',
            ],
            'timeout' => 30,
        ]);
    }

    /**
     * Upsert vectors into the index
     * 
     * @param array $vectors
     */
    public function upsert(array $vectors): void
    {
        $response = $this->client->post($this->endpoint . '/vectors/upsert', [
            'json' => [
                'vectors' => $vectors,
            ],
        ]);

        //echo "\nResponse:\n\t" . $response->getStatusCode();
        //echo "\n\t" . $response->getBody() . "\n";
        
        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException(
                'Pinecone upsert failed: ' . $response->getBody()
            );
        }
    }

    /**
     * Query the index for similar vectors
     * 
     * @param array $vector
     * @param int $topK
     * @return array
     */
    public function query(array $vector, int $topK = 5): array
    {
        $response = $this->client->post(
            $this->endpoint . '/query',
            [
                'json' => [
                    'vector' => $vector,
                    'topK' => $topK,
                    'includeMetadata' => true,
                ],
            ]
        );

        $data = json_decode($response->getBody(), true);

        return $data['matches'] ?? [];
    }

    /**
     * Delete all vectors from the index
     */
    public function deleteAll(): void
    {
        $response = $this->client->post(
            $this->endpoint . '/vectors/delete',
            [
                'json' => [
                    'deleteAll' => true,
                ],
            ]
        );

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException(
                'Pinecone deleteAll failed: ' . (string) $response->getBody()
            );
        }
    }
}

?>