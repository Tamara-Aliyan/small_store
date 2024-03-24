<?php

use App\Http\Controllers\Api\V1\CategoriesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
Route::apiResource('categories', CategoriesController::class)->except('update');
Route::put('categories/{category}', [CategoriesController::class, 'update'])
    ->name('categories.update');
});
