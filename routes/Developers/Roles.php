<?php

use App\Http\Controllers\Api\V1\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions']);
});
