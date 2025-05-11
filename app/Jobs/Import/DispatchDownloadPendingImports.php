<?php

namespace App\Jobs\Import;

use App\Enums\SyncStatus;
use App\Models\Import;
use App\Modules\Imports\Repositories\Imports;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DispatchDownloadPendingImports implements ShouldQueue
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
    public function handle(Imports $imports): void
    {
        $imports->allNotStarted()
            ->each(fn (Import $import) => dispatch(new DownloadImport($import)));
    }
}
