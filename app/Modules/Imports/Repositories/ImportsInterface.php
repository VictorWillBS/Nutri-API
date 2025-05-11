<?php

declare(strict_types=1);

namespace App\Modules\Imports\Repositories;

use App\Models\Import;

interface ImportsInterface
{
    public function create(array $data): Import;
}