<?php

namespace App\Models;

use App\Enums\Products\ProductStatus;
use Carbon\Carbon;
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
            'imported_t' => 'datetime',
        ];
    }

    public function convert(array $data): array
    {
        return array_map(
            function ($data) {
                $data = json_decode($data, true);

                return [
                    'code' => preg_replace('/[^\d]+/', '', $data['code']),
                    'data' => Arr::except($data, ['code', 'product_name', 'url']),
                    'name' => $data['product_name'],
                    'url' => $data['url'],
                    'status' => ProductStatus::Published,
                    'imported_t' => Carbon::now()->format('Y-m-d H:i:s'),
                ];
            },
            $data
        );
    }
}
