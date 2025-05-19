<?php

declare(strict_types=1);

namespace App\Jobs\Import;

use App\Models\Import;
use App\Modules\Imports\Repositories\Imports;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Redis\RedisManager;

class ContinueProcessingFailedImports implements ShouldQueue
{
    use Queueable;

    public function __construct() {}

    public function handle(Imports $imports, RedisManager $redis): void
    {
        $imports->allProcessing()
            ->each(
                function (Import $import) {
                    $index = array_search(
                        $import->last_imported_item_code,
                        array_column($import->data->toArray(), 'code')
                    );
                    $import->update(['data' => array_slice($import->data->toArray(), $index, 1)]);
                    dispatch(new ProcessImportData($import));
                }
            );

        $redis->set('cron_last_execution', now()->toDateTimeString());
    }
}
