<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function summarize(Request $request)
    {
        $text = $request->text;

        if (!$text) {
            return response()->json([
                'error' => true,
                'message' => 'Teks tidak boleh kosong'
            ]);
        }

        try {
            // GROQ API - Gratis & Sangat Cepat!
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->timeout(30)->post("https://api.groq.com/openai/v1/chat/completions", [
                "model" => "llama-3.3-70b-versatile", // Model terbaik gratis
                "messages" => [
                    [
                        "role" => "system",
                        "content" => "Kamu adalah asisten yang ahli meringkas teks dengan jelas, singkat, dan padat dalam Bahasa Indonesia."
                    ],
                    [
                        "role" => "user",
                        "content" => "Ringkas teks berikut dengan jelas dan singkat:\n\n" . $text
                    ]
                ],
                "temperature" => 0.7,
                "max_tokens" => 1000,
            ]);

            if ($response->failed()) {
                return response()->json([
                    "error" => true,
                    "message" => "API Error: " . $response->body()
                ], $response->status());
            }

            $json = $response->json();

            return response()->json([
                "error" => false,
                "summary" => $json["choices"][0]["message"]["content"] ?? "Tidak ada hasil"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}