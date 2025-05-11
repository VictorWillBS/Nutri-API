<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $attributes = [
        'data' => '[]',
    ];

    protected $fillable = [
        'filename',
        'status',
        'data',
        'final_convert',
        'type',
        'last_imported_item_code',
    ];

    protected $casts = [
        'data' => AsArrayObject::class,
    ];

    public function convert(array $data, Import $import): array
    {
        return array_map(
            fn($data) => [
                'filename' => $data,
                'type' =>  $import['final_convert']
            ],
            $data
        );
    }
}
