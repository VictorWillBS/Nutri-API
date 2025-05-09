<?php

declare(strict_types=1);

namespace App\Modules\Products\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductsInterface
{
    public function all(): Collection;

    public function delete(int $id): void;

    public function findOrFail(int $id): Product;

    public function update(array $data): Product;
}