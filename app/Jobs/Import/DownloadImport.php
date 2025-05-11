<?php

namespace App\Jobs\Import;

use App\Enums\SyncStatus;
use App\Models\Import;
use App\Modules\Imports\Services\Import as ServicesImport;
use App\Support\FileEditor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DownloadImport implements ShouldQueue
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
    public function handle(ServicesImport $service): void
    {
        $this->import->update(['status' => SyncStatus::Started]);

        $directory = str_replace('App\\Models\\', '', $this->import->type);
        $data = $service->getFileData($this->import->filename);
        $fileEditor = new FileEditor($this->import->filename, $directory, $data);

        $fileEditor->store();

        $this->import->update(['status' => SyncStatus::Downloaded, 'filename' => $fileEditor->getFilename()]);

        dispatch(new ConvertFileToData($this->import));
    }
}
