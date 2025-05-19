<?php

use App\Jobs\Import\ContinueProcessingFailedImports;
use App\Jobs\Import\DeleteCompletedImports;
use App\Jobs\Import\DispatchDownloadPendingImports;
use App\Jobs\Import\ProcessReadyImports;
use App\Jobs\Products\DailyProductsUpdate;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new DispatchDownloadPendingImports())->everyMinute();
Schedule::job(new ProcessReadyImports())->everyMinute();
Schedule::job(new ContinueProcessingFailedImports())->everyTenMinutes();
Schedule::job(new DeleteCompletedImports())->everyFiveMinutes();
Schedule::job(new DailyProductsUpdate())->everyTenMinutes();
