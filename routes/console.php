<?php

use App\Models\WaQueue;
use App\Jobs\ProcessWaQueue;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Console\ClosureCommand;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $jobs = WaQueue::where('status', 'pending')
        ->where('scheduled_at', '<=', now())
        ->get();

    foreach ($jobs as $job) {
        ProcessWaQueue::dispatch($job);
    }
})->everyMinute();
