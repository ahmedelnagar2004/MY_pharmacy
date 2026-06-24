<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AIChatController extends Controller
{
    public function ask(Request $request)
    {
<<<<<<< HEAD
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
=======
        $question = $request->input('question');
        $openrouterKey = config('openrouter.api_key');

        // Primary: OpenRouter — try multiple free models in order
        $models = [
            'google/gemma-3-12b-it:free',
            'google/gemma-3-27b-it:free',
            'meta-llama/llama-3.2-3b-instruct:free',
            'openai/gpt-oss-20b:free',
            'meta-llama/llama-3.3-70b-instruct:free',
        ];

        foreach ($models as $model) {
            try {
                $client = new Client(['timeout' => 30, 'connect_timeout' => 10]);

                $response = $client->post('https://openrouter.ai/api/v1/chat/completions', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $openrouterKey,
                        'Content-Type'  => 'application/json',
                    ],
                    'json' => [
                        'model'    => $model,
                        'messages' => [['role' => 'user', 'content' => $question]],
                    ],
                ]);

                $data   = json_decode($response->getBody()->getContents(), true);
                $answer = $data['choices'][0]['message']['content'] ?? null;

                if ($answer) {
                    return response()->json(['answer' => $answer]);
                }

            } catch (\Exception $e) {
                \Log::warning('AIChat OpenRouter model failed (' . $model . '): ' . $e->getMessage());
            }
>>>>>>> 1c0012bee38cf313557ad7a8a4ab4079b7510318
        }

        // Fallback: Gemini
        $geminiKeys = array_filter([config('gemini.api_key'), config('gemini.fallback_key')]);

        foreach ($geminiKeys as $key) {
            try {
                $client = new Client(['timeout' => 30, 'connect_timeout' => 10]);

                $response = $client->post(
                    'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-001:generateContent?key=' . $key,
                    [
                        'headers' => ['Content-Type' => 'application/json'],
                        'json'    => [
                            'contents' => [[
                                'role'  => 'user',
                                'parts' => [['text' => $question]],
                            ]],
                        ],
                    ]
                );

                $data   = json_decode($response->getBody()->getContents(), true);
                $answer = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No answer received.';

                return response()->json(['answer' => $answer]);

            } catch (\Exception $e) {
                \Log::error('AIChat Gemini key failed: ' . $e->getMessage());
            }
        }

        return response()->json(['answer' => 'All AI services are currently unavailable. Please try again later.']);
    }
}
