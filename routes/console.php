<?php

use App\Models\WaQueue;
use App\Jobs\ProcessWaQueue;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    // Ambil semua job pending yang waktunya <= sekarang & belum dijadwalkan
    $jobs = WaQueue::where('status', 'pending')
        ->where('scheduled_at', '<=', now())
        ->where('is_scheduled', false) // baru
        ->get();

    Log::info("Scheduler berjalan, menemukan {$jobs->count()} job pending");

    foreach ($jobs as $index => $job) {
        // Tambahkan delay acak antar job
        $delaySeconds = rand(30, 90) + ($index * 5);

        // Tandai sudah dijadwalkan
        $job->update(['is_scheduled' => true]);

        ProcessWaQueue::dispatch($job)->delay(now()->addSeconds($delaySeconds));

        Log::info("Job ID {$job->id} dijadwalkan dengan delay {$delaySeconds} detik");
    }
})->everyTwoMinutes();
