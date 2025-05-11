<?php

namespace App\Jobs\Import;

use App\Models\Import;
use App\Modules\Imports\Repositories\Imports;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessReadyImports implements ShouldQueue
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
        $imports->allReady()
            ->each(fn ($import) => dispatch(new ProcessImportData($import)));
    }
}
