<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function summarize(Request $request, $id)
{
    // FIX: Ganti Notes jadi Note (singular)
    $note = Notes::findOrFail($id);

    // Ambil teks dari deskripsi note
    $text = $note->deskripsi;

    if (!$text) {
        return response()->json([
            'error' => true,
            'message' => 'Teks tidak boleh kosong'
        ]);
    }

    try {
        // GROQ API
        $response = Http::withOptions([
            'verify' => config('services.groq.verify_ssl')
        ])->withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
            'Content-Type' => 'application/json',
        ])->timeout(30)->post("https://api.groq.com/openai/v1/chat/completions", [
            "model" => "llama-3.3-70b-versatile",
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
    public function generateTodo(Request $request, $id)
    {
        // Ambil note dari database
        $note = Notes::findOrFail($id);

        // Ambil teks dari deskripsi note
        $text = $note->deskripsi;

        if (!$text) {
            return response()->json([
                'error' => true,
                'message' => 'Teks tidak boleh kosong'
            ]);
        }

        try {
            // Ambil to-do list yang lama (jika ada)
            $oldTodos = json_decode($note->todo_list, true) ?? [];

            // Buat map dari teks yang sudah completed
            $completedMap = [];
            foreach ($oldTodos as $todo) {
                if ($todo['completed']) {
                    // Simpan teks yang sudah completed (lowercase untuk matching)
                    $completedMap[strtolower(trim($todo['text']))] = true;
                }
            }

            // GROQ API - Generate To-Do List
            $response = Http::withOptions([
                'verify' => config('services.groq.verify_ssl')
            ])->withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->timeout(30)->post("https://api.groq.com/openai/v1/chat/completions", [
                "model" => "llama-3.3-70b-versatile",
                "messages" => [
                    [
                        "role" => "system",
                        "content" => "Kamu adalah asisten yang ahli membuat daftar tugas (to-do list) dari catatan. Buatlah to-do list yang actionable, jelas, dan terstruktur dalam Bahasa Indonesia. Format setiap item dengan format berikut (satu baris per item, tanpa numbering):\n- Item pertama\n- Item kedua\n- Item ketiga"
                    ],
                    [
                        "role" => "user",
                        "content" => "Buatkan to-do list dari catatan berikut:\n\n" . $text
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
            $todoText = $json["choices"][0]["message"]["content"] ?? "Tidak ada hasil";

            // Parse to-do list menjadi array
            $todoLines = explode("\n", $todoText);
            $todoItems = [];

            foreach ($todoLines as $line) {
                $line = trim($line);
                // Ambil item yang dimulai dengan "-" atau "•" atau angka
                if (preg_match('/^[-•\d]+[\.\)]*\s*(.+)/', $line, $matches)) {
                    $itemText = trim($matches[1]);
                    $itemTextLower = strtolower($itemText);

                    // Cek apakah item ini sudah pernah di-checklist
                    $isCompleted = isset($completedMap[$itemTextLower]);

                    $todoItems[] = [
                        'text' => $itemText,
                        'completed' => $isCompleted // Pertahankan status completed
                    ];
                }
            }

            // Simpan to-do list ke database (JSON format)
            $note->todo_list = json_encode($todoItems);
            $note->save();

            return response()->json([
                "error" => false,
                "todo" => $todoItems,
                "message" => "To-Do List berhasil dibuat dan disimpan!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function updateTodoItem(Request $request, $id)
    {
        try {
            $note = Notes::findOrFail($id);

            $todoList = json_decode($note->todo_list, true);

            if (!$todoList) {
                return response()->json([
                    'error' => true,
                    'message' => 'To-Do list tidak ditemukan'
                ], 404);
            }

            $index = $request->input('index');
            $completed = $request->input('completed');

            if (isset($todoList[$index])) {
                $todoList[$index]['completed'] = $completed;
                $note->todo_list = json_encode($todoList);
                $note->save();

                return response()->json([
                    'error' => false,
                    'message' => 'Status berhasil diupdate'
                ]);
            }

            return response()->json([
                'error' => true,
                'message' => 'Item tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // ========== FUNCTION REWRITE (Perbaiki Bahasa) ==========
    public function rewrite(Request $request, $id)
    {
        $note = Notes::findOrFail($id);
        $text = $note->deskripsi;

        if (!$text) {
            return response()->json([
                'error' => true,
                'message' => 'Teks tidak boleh kosong'
            ]);
        }

        try {
            $response = Http::withOptions([
                'verify' => config('services.groq.verify_ssl')
            ])->withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->timeout(30)->post("https://api.groq.com/openai/v1/chat/completions", [
                "model" => "llama-3.3-70b-versatile",
                "messages" => [
                    [
                        "role" => "system",
                        "content" => "Kamu adalah asisten ahli bahasa Indonesia yang bertugas memperbaiki tata bahasa, ejaan, dan struktur kalimat. Perbaiki teks menjadi lebih formal, jelas, dan mudah dipahami. PENTING: Jangan ubah makna atau isi, hanya perbaiki bahasanya."
                    ],
                    [
                        "role" => "user",
                        "content" => "Perbaiki tata bahasa dan ejaan teks berikut:\n\n" . $text
                    ]
                ],
                "temperature" => 0.3,
                "max_tokens" => 1500,
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
                "rewritten" => $json["choices"][0]["message"]["content"] ?? "Tidak ada hasil"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    // ========== FUNCTION EXPAND (Kembangkan Catatan) ==========
    public function expand(Request $request, $id)
    {
        $note = Notes::findOrFail($id);
        $text = $note->deskripsi;

        if (!$text) {
            return response()->json([
                'error' => true,
                'message' => 'Teks tidak boleh kosong'
            ]);
        }

        try {
            $response = Http::withOptions([
                'verify' => config('services.groq.verify_ssl')
            ])->withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->timeout(30)->post("https://api.groq.com/openai/v1/chat/completions", [
                "model" => "llama-3.3-70b-versatile",
                "messages" => [
                    [
                        "role" => "system",
                        "content" => "Kamu adalah asisten yang ahli mengembangkan dan memperluas catatan. Tugasmu adalah menambahkan detail, penjelasan, dan elaborasi pada teks yang diberikan. Buatlah teks menjadi lebih lengkap, informatif, dan mudah dipahami. Tambahkan contoh dan penjelasan yang relevan."
                    ],
                    [
                        "role" => "user",
                        "content" => "Kembangkan dan perluas catatan berikut menjadi lebih detail dan informatif:\n\n" . $text
                    ]
                ],
                "temperature" => 0.7,
                "max_tokens" => 2000,
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
                "expanded" => $json["choices"][0]["message"]["content"] ?? "Tidak ada hasil"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
