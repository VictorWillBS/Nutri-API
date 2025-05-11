<?php

namespace App\Jobs\Import;

use App\Enums\SyncStatus;
use App\Models\Import;
use App\Support\FileEditor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ConvertFileToData implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Import $import)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(FileEditor $fileEditor): void
    {
        $path = str_replace('App\\Models\\', '', $this->import->type);
        $fileEditor = new FileEditor($this->import->filename, $path);
        $data = $fileEditor->get();

        if (is_string($data)) {
            $data =$fileEditor->txtToArray();
        }

        $convertedData = resolve($this->import->type)->convert($data, $this->import);

        $this->import->update(['data' => $convertedData, 'status' => SyncStatus::Ready]);
    }
}
