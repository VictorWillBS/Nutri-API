<?php

namespace Database\Seeders\Setup;

use App\Enums\SyncStatus;
use App\Models\Import;
use App\Models\Product;
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
        $import->filename = 'index.txt';
        $import->status = SyncStatus::NotStarted;
        $import->final_convert = Product::class;
        $import->type = Import::class;
        $import->save();
    }
}
