<?php

namespace Database\Seeders;

use Database\Seeders\Setup\AddFirstImportIndex;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $firstImport = new AddFirstImportIndex();
       $firstImport->run();
    }
}
