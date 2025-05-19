<?php

use App\Http\Controllers\Meta\StatusController;
use App\Http\Controllers\Products\ProductsController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::withoutMiddleware([VerifyCsrfToken::class])->group(
    function () {
        Route::get('/', [StatusController::class, 'index'])->name('meta.status');
        Route::apiResource('/products', ProductsController::class);
    }
);
