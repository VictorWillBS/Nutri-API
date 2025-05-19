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

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(Imports $imports, RedisManager $redis): void
    {
        $imports->allReady()
            ->each(fn ($import) => dispatch(new ProcessImportData($import)));

        $redis->set('cron_last_execution', now()->toDateString());
    }
}
