<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Modules\Products\Repositories\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct(protected Products $products) {}

    public function index()
    {
        return $this->products->all();
    }

    public function show(int $id)
    {
        return $this->products->findOrFail($id);
    }

    public function update(Request $request)
    {
        return $this->products->update($request->all());
    }

    public function delete(int $id)
    {
        return $this->products->delete($id);
    }
}
