<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AIChatController extends Controller
{
    public function ask(Request $request)
    {
    //    dd(env('GEMINI_API_KEY'));
        try {
            $question = $request->input('question');
            $apiKey = env('GEMINI_API_KEY');
            if (!$apiKey) {
                return response()->json(['answer' => 'API KEY IS EMPTY']);
            }

            $client = new \GuzzleHttp\Client();
            $response = $client->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey, [
                'Content-Type'  => 'application/json',
                'json' => [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $question]
                            ]
                        ]
                    ]
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $answer = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No answer received.';
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
