<?php

namespace App\Jobs\Import;

use App\Models\Import;
use App\Modules\Imports\Repositories\Imports;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Redis\RedisManager;

class ProcessReadyImports implements ShouldQueue,ShouldBeUnique
{
    use Queueable;

    public function __construct() {}

    public function handle(Imports $imports, RedisManager $redis): void
    {
        $imports->allReady()
            ->each(fn ($import) => dispatch(new ProcessImportData($import)));

        $redis->set('cron_last_execution', now()->toDateTimeString());
    }
}
