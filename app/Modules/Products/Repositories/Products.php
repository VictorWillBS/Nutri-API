<?php

declare(strict_types=1);

namespace App\Modules\Products\Repositories;

use App\Enums\Products\ProductStatus;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class Products
{
   public function __construct(protected Product $product) {}

    public function all(): LengthAwarePaginator
    {
        return Product::paginate(10);
    }

    public function allAbleToDailyUpdate(): Collection
    {
        return $this->product->whereNot('status', ProductStatus::Trashed)
            ->where('synced_at', '<', Carbon::today())
            ->orWhere('synced_at', null)
            ->limit(50)
            ->get();
    }

    public function delete(string $code): void
    {
        $product = $this->firstByCodeOrFail($code);
        $product->status = ProductStatus::Trashed;
        $product->save();
        $product->delete();
    }

    public function firstByCodeOrFail(string $code): Product
    {
        return $this->product->whereCode($code)->firstOrFail();
    }

    public function update(string $code, array $data): Product
    {
        $product = $this->firstByCodeOrFail($code);
        $product->fill($data);
        $product->save();

        return $product;
    }
}
