<?php

use App\Models\WaQueue;
use App\Jobs\ProcessWaQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    // Ambil semua job pending yang belum dijadwalkan
    $jobs = WaQueue::where('status', 'pending')
        ->where('scheduled_at', '<=', now())
        ->where('is_scheduled', false)
        ->get();

    $count = $jobs->count();

    // Hanya log jika ada job baru
    if ($count > 0) {
        Log::info("Scheduler berjalan, menemukan {$count} job pending");
    }

    foreach ($jobs as $index => $job) {
        // Tambahkan delay acak antar job
        $delaySeconds = rand(30, 90) + ($index * 5);

        // Tandai sudah dijadwalkan agar tidak dijalankan ulang
        $job->update(['is_scheduled' => true]);

        // Dispatch job ke queue dengan delay
        ProcessWaQueue::dispatch($job)->delay(now()->addSeconds($delaySeconds));

        // Log job yang dijadwalkan
        Log::info("Job ID {$job->id} dijadwalkan dengan delay {$delaySeconds} detik");
    }
})->everyTwoMinutes(); // Atau everyMinute() sesuai kebutuhan
