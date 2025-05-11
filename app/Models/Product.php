<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

class Product extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'url',
        'data',
        'status',
        'imported_t',
    ];

    protected function casts(): array
    {
        return [
            'data' => AsArrayObject::class,
        ];
    }

    public function convert(array $data, Import $import): array
    {
        return [];
        return array_map(
            fn($data) => [
                'code' => $data['code'],
                'data' => Arr::except($data, ['code', 'product_name', 'url']),
                'name' => $data['product_name'],
                'url' => $data['url'],
                'status' => ProductStatus::Published,
                'imported_t' => now()
            ],
            $data
        );
    }
}
