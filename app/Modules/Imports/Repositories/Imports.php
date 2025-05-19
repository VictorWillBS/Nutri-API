<?php

declare(strict_types=1);

namespace App\Modules\Imports\Repositories;

use App\Enums\SyncStatus;
use App\Models\Import;
use Illuminate\Database\Eloquent\Collection;

class Imports
{
    public function __construct(protected Import $import) {}

    public function create(array $data): Import
    {
        $import = $this->import->newInstance($data);

        return $import;
    }

    public function allNotStarted(): Collection
    {
        return $this->import->newQuery()->whereStatus(SyncStatus::NotStarted)->get();
    }

    public function allReady(): Collection
    {
        return $this->import->newQuery()->whereStatus(SyncStatus::Ready)->get();
    }

    public function allCompleted(): Collection
    {
        return $this->import->newQuery()->where('Status', SyncStatus::Completed)->get();
    }

     public function allProcessing(): Collection
    {
        return $this->import->newQuery()->where('Status', SyncStatus::Processing)->get();
    }
}
