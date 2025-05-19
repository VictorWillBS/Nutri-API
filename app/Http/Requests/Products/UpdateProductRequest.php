<?php

declare(strict_types=1);

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_name' => 'sometimes|string',
            'url' => 'sometimes|string',
            'data' => 'sometimes|array',
            'status' => 'sometimes|string',
        ];
    }
}
