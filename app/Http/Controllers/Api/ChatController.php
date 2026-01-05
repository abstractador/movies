<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PineconeService;
use App\Services\OpenAIEmbeddingService;
use GuzzleHttp\Client;

class ChatController extends Controller
{
    /**
     * Handle chat requests
     * 
     * @param Request $request
     * @param PineconeService $pinecone
     * @param OpenAIEmbeddingService $embeddings
     * @return \Illuminate\Http\JsonResponse
     */
    public function chat(Request $request, PineconeService $pinecone, OpenAIEmbeddingService $embeddings)
    {

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $query = $request->input('message');

        $queryVector = $embeddings->embed($query);

        $matches = $pinecone->query(
            vector: $queryVector,
            topK: 5
        );

        $context = collect($matches)
            ->pluck('metadata.title')
            ->implode(', ');

        $answer = $this->askOpenAi($query, $context);

        return response()->json([
            'answer' => $answer,
            'sources' => $matches,
        ]);
    }

    /**
     * Ask OpenAI a question with context
     * 
     * @param string $question
     * @param string $context
     * @return string
     */
    protected function askOpenAi(string $question, string $context): string
    {
        $client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.openai.key'),
                'Content-Type' => 'application/json',
            ],
        ]);

        $response = $client->post('chat/completions', [
            'json' => [
                'model' => 'gpt-4.1-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful Movies AI assistant. Recommend and explain movies clearly.',
                    ],
                    [
                        'role' => 'system',
                        'content' => "Relevant movies: {$context}",
                    ],
                    [
                        'role' => 'user',
                        'content' => $question,
                    ],
                ],
                'temperature' => 0.7,
            ],
        ]);

        return data_get(
            json_decode($response->getBody(), true),
            'choices.0.message.content',
            'Sorry, I could not find a good answer.'
        );
    }
}

?>