<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

$dev_path = __DIR__ . './Developers/';
$auth_path = __DIR__ . './Auth/';

Route::prefix('v1')->group(function () use ($dev_path) {

    // Users routes
    include "{$dev_path}Users.php";

    // Products routes
    include "{$dev_path}Products.php";

    // Categories routes
    include "{$dev_path}Categories.php";
    //Roles routes
    include "{$dev_path}Roles.php";


});

Route::group(['prefix' => 'auth'], function ()use($auth_path) {

    include "{$auth_path}auth.php";
});
