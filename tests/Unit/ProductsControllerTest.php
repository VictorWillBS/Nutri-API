<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Mockery;
use App\Modules\Products\Repositories\Products;
use App\Http\Controllers\Products\ProductsController;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductsControllerTest extends TestCase
{
    protected $products;
    protected ProductsController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->products = Mockery::mock(Products::class);
        $this->controller = new ProductsController($this->products);
    }

    public function testIndexReturnsAllProducts()
    {
        $expected = new LengthAwarePaginator([
            Product::factory()->make(),
            Product::factory()->make(),
        ], 12, 1);

        $this->products->shouldReceive('all')
            ->once()
            ->andReturn($expected);

        $result = $this->controller->index();

        $this->assertSame($expected, $result);
    }

    public function testShowReturnsProductByCode()
    {
        $code = 'ABC123';
        $expected = Product::factory()->make(['code' => $code]);

        $this->products->shouldReceive('firstByCodeOrFail')
            ->once()
            ->with($code)
            ->andReturn($expected);

        $result = $this->controller->show($code);

        $this->assertSame($expected, $result);
    }

    public function testUpdateCallsRepositoryWithData()
    {
        $code = 'ABC123';
        $data = ['name' => 'Updated'];

        $expected = Product::factory()->make(['code' => $code, 'name' => $data['name']]);

        $request = Mockery::mock(UpdateProductRequest::class);
        $request->shouldReceive('all')->once()->andReturn($data);

        $this->products->shouldReceive('update')
            ->once()
            ->with($code, $data)
            ->andReturn($expected);

        $result = $this->controller->update($code, $request);

        $this->assertSame($expected, $result);
    }

    public function testDestroyDeletesProductByCode()
    {
        $code = 'ABC123';
        $expected = Product::factory()->make(['code' => $code]);

        $this->products->shouldReceive('delete')
            ->once()
            ->with($code)
            ->andReturn($expected);

        $result = $this->controller->destroy($code);

        $this->assertNull($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
