<?php

namespace App\Services\Jimpitan;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    // protected string $token;

    // public function __construct()
    // {
    //     $this->token = config('services.fonnte.token'); // simpan token di .env
    // }

    // public function sendMessage(string $target, string $message): array
    // {
    //     $response = Http::withHeaders([
    //         'Authorization' => $this->token,
    //     ])->asForm()->post('https://api.fonnte.com/send', [
    //         'target' => $target,   // Nomor tujuan
    //         'message' => $message, // Pesan WA
    //     ]);

    //     return $response->json();
    // }

    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $this->baseUrl = config('services.wagateway.url'); // contoh: http://127.0.0.1:3000
        $this->token = env('WA_GATEWAY_TOKEN'); // ambil token dari env
    }

    public function sendMessage(string $target, string $message): array
    {
        if (!$this->token) {
            return ['error' => 'Token WA Gateway belum diatur'];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post($this->baseUrl . '/api/wa/send', [
            'number' => $target,
            'message' => $message,
        ]);

        return $response->json();
    }
}
