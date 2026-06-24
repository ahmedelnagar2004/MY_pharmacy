<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AIChatController extends Controller
{
    public function ask(Request $request)
    {
        try {
            $question = $request->input('question');
            $apiKey = env('OPENROUTER_API_KEY');
            if (!$apiKey) {
                return response()->json(['answer' => 'API KEY IS EMPTY']);
            }

            $models = [
                'meta-llama/llama-3.3-70b-instruct:free',
                'qwen/qwen3-next-80b-a3b-instruct:free',
                'openai/gpt-oss-120b:free',
                'openai/gpt-oss-20b:free',
                'nvidia/nemotron-nano-9b-v2:free',
            ];

            $client = new \GuzzleHttp\Client();
            $data = null;
            $lastError = null;

            foreach ($models as $model) {
                try {
                    $response = $client->post('https://openrouter.ai/api/v1/chat/completions', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $apiKey,
                            'Content-Type'  => 'application/json',
                        ],
                        'json' => [
                            'model' => $model,
                            'messages' => [
                                [
                                    'role' => 'user',
                                    'content' => $question,
                                ],
                            ],
                        ],
                    ]);

                    $data = json_decode($response->getBody(), true);
                    break;
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    $lastError = $e;
                    continue;
                }
            }

            if ($data === null) {
                throw $lastError ?? new \Exception('No free model available right now.');
            }

            $answer = $data['choices'][0]['message']['content'] ?? 'No answer received.';
            return response()->json([
                'answer' => $answer
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'answer' => 'خطأ تقني: ' . $e->getMessage() . ' | ' . $e->getTraceAsString()
            ]);
        }
    }
}