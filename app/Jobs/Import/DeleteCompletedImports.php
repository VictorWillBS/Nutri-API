<?php

declare(strict_types=1);

namespace App\Jobs\Import;

use App\Models\Import;
use App\Modules\Imports\Repositories\Imports;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Redis\RedisManager;

class DeleteCompletedImports implements ShouldQueue
{
    use Queueable;

    public function __construct() {}

    public function handle(Imports $imports, RedisManager $redis): void
    {
        $imports->allCompleted()
            ->each(fn(Import $import) => $import->delete());

        $redis->set('cron_last_execution', now()->toDateTimeString());
    }
}
