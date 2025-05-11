<?php

namespace Database\Seeders;

use App\Enums\SyncStatus;
use App\Models\Import;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddFirstImportIndex extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $import = new Import();
        $import->filename = 'index';
        $import->status = SyncStatus::NotStarted;
        $import->save();
    }
}
