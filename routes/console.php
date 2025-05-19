<?php

use App\Jobs\Import\DispatchDownloadPendingImports;
use App\Jobs\Import\ProcessReadyImports;
use App\Jobs\Products\DailyProductsUpdate;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new DispatchDownloadPendingImports())->everyMinute();
Schedule::job(new ProcessReadyImports())->everyFiveMinutes();
Schedule::job(new DailyProductsUpdate())->everyTenMinutes();
