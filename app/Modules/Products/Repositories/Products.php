<?php

declare(strict_types=1);

namespace App\Modules\Products\Repositories;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class Products
{
   public function __construct(protected Product $product) {}

    public function all(): Collection
    {
        return $this->product->newQuery()->all();
    }

    public function delete(int $id): void
    {
        $product = $this->findOrFail($id);

        $product->status = ProductStatus::Trashed;
        $product->trashed();
    }

    public function findOrFail(int $id): Product
    {
        return $this->product->findOrFail($id);
    }

    public function update(array $data): Product
    {
        $product = $this->findOrFail($data['id']);
        $product->fill($data);
        $product->save();

        return $product;
    }
}