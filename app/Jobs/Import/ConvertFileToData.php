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

    public function __construct(protected Import $import) {}

    public function handle(): void
    {
        $path = str_replace('App\\Models\\', '', $this->import->type);
        $fileEditor = new FileEditor($this->import->filename, $path);
        $data = $fileEditor->get();

        if (str_ends_with($this->import->filename, '.txt')) {
            $data = $fileEditor->txtToArray();
        }

        if (str_ends_with($this->import->filename, '.json')) {
            $data = json_decode($data, true);
        }

        $convertedData = resolve($this->import->type)->convert($data, $this->import);

        $this->import->update(['data' => $convertedData, 'status' => SyncStatus::Ready]);
    }
}
