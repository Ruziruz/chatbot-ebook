<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $client = new Client();
        $context= "jawab menggunakan bahasa indonesia";
        // $context = "Berikut adalah konteks yang harus digunakan untuk menjawab pertanyaan:\n"
        //          . "1. Halaman 1: [Tulis teks halaman 1 di sini].\n"
        //          . "2. Halaman 2: [Tulis teks halaman 2 di sini].\n"
        //          . "Jawablah hanya berdasarkan konteks di atas.";
        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            "role" => "system",
                            "content" => $context
                        ],
                        [
                            'role' => 'user',
                            'content' => $request->input('message'),
                        ]
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            if (isset($data['choices'][0]['message']['content'])) {
                return response()->json(["reply" => $data['choices'][0]['message']['content']]);
            } else {
                Log::error('Invalid response format', ['response' => $data]);
                return response()->json(["reply" => "Error: Invalid response format."], 500);
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('API request failed', ['error' => $e->getMessage()]);
            return response()->json(["reply" => "Error: API request failed."], 500);
        } catch (\Exception $e) {
            Log::error('General error occurred', ['error' => $e->getMessage()]);
            return response()->json(["reply" => "Error: Something went wrong."], 500);
        }
    }
}