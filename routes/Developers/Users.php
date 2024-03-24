<?php

use App\Http\Controllers\Api\V1\UsersController;
use Illuminate\Support\Facades\Route;


    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('users', UsersController::class)->except('update');
        Route::post('users/{user}', [UsersController::class, 'update'])
            ->name('users.update');
        });
