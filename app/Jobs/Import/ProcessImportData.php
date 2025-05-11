<?php

namespace App\Jobs\Import;

use App\Enums\SyncStatus;
use App\Models\Import;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessImportData implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $import)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->import->update(['status' => SyncStatus::Processing]);

        $isMetaImportation = $this->import->type === Import::class;

        foreach ($this->import->data as $data) {
            /** @var \Illuminate\Database\Eloquent\Model $model */
            $model = $isMetaImportation ? $this->import->newInstance() : resolve($this->import->type);
            $model->fill($data);
            $model->save();

            $this->import->update([
                'last_imported_item_code' => $model->code ?? $model->id,
            ]);
        }

        $this->import->update(['status' => SyncStatus::Completed]);
    }
}
