<?php

namespace App\Console\Commands;

use App\Models\WaQueue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendQueuedWa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-queued-wa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pending = WaQueue::where('status', 'pending')
            ->where('scheduled_at', '<=', now())
            ->get();

        foreach ($pending as $item) {
            try {
                $warga = $item->warga;
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . config('services.wagateway.token'),
                ])->post(config('services.wagateway.url') . '/api/wa/send', [
                    'number' => preg_replace('/^0/', '62', $warga->no_telp),
                    'message' => $item->message,
                ]);

                $item->update([
                    'status' => 'sent',
                ]);
            } catch (\Exception $e) {
                $item->update(['status' => 'failed']);
            }

            // Optional: sleep 5 detik antar pesan supaya tidak ngebut
            sleep(5);
        }
    }
}
