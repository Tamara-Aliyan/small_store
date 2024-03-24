<?php

use App\Http\Controllers\Api\V1\ProductsController;
use Illuminate\Support\Facades\Route;

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('products', ProductsController::class)->except('update');
        Route::post('products/{product}', [ProductsController::class, 'update'])
            ->name('products.update');
        Route::post('products/{product}', [ProductsController::class, 'updateStatus']);
    });
