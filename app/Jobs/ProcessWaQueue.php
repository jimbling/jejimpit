<?php

namespace App\Jobs;

use App\Models\WaQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessWaQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $waQueue;

    public function __construct(WaQueue $waQueue)
    {
        $this->waQueue = $waQueue;
    }

    public function handle()
    {
        if ($this->waQueue->status !== 'pending') return;

        // Kirim WA via gateway
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.wagateway.token'),
        ])->post(config('services.wagateway.url') . '/api/wa/send', [
            'number' => preg_replace('/^0/', '62', $this->waQueue->warga->no_telp),
            'message' => $this->waQueue->message,
        ]);

        $res = $response->json();

        // Update status WA Queue
        $this->waQueue->update([
            'status' => $res['success'] ? 'sent' : 'failed',
        ]);
    }
}
