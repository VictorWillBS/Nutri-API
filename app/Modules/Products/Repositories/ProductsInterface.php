<?php

declare(strict_types=1);

namespace App\Modules\Products\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductsInterface
{
    public function all(): LengthAwarePaginator;

    public function allAbleToDailyUpdate(): Collection;

    public function delete(string $code): void;

    public function firstByCodeOrFail(string $code): Product;

    public function update(string $code, array $data): Product;
}
