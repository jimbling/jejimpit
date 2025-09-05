<?php

namespace App\Services\Jimpitan;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    protected string $token;

    public function __construct()
    {
        $this->token = config('services.fonnte.token'); // simpan token di .env
    }

    public function sendMessage(string $target, string $message): array
    {
        $response = Http::withHeaders([
            'Authorization' => $this->token,
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target' => $target,   // Nomor tujuan
            'message' => $message, // Pesan WA
        ]);

        return $response->json();
    }
}
