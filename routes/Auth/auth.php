<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\{AuthController,AuthNotificationController};


Route::controller(AuthController::class)
    ->group(function(){
        Route::post('login','login');
        Route::post('signup','signup');
        Route::post('logout','logout')->middleware('auth:sanctum');
});

Route::controller(AuthNotificationController::class)
        ->middleware('auth:sanctum')
        ->prefix('admin/notifications')->group(function () {
            Route::get('/all', 'index');
            Route::get('/unread', 'unread');
            Route::post('/markReadAll', 'markReadAll');
            Route::delete('/deleteAll', 'deleteAll');
            Route::delete('/delete/{id}', 'delete');
        });
