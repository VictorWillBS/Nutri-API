<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Modules\Products\Repositories\Products;

class ProductsController extends Controller
{
    public function __construct(protected Products $products) {}

    public function index()
    {
        return $this->products->all();
    }

    public function show(string $code)
    {
        return $this->products->firstByCodeOrFail($code);
    }

    public function update(string $code, UpdateProductRequest $request)
    {
        return $this->products->update($code, $request->all());
    }

    public function destroy(string $code)
    {
        return $this->products->delete($code);
    }
}
