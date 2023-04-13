<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoriesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => 'api', 'prefix' => 'categories'], function ($router) {
    Route::get('/getcategories', [CategoriesController::class, 'getAllCategories']);
});

Route::group(['middleware' => 'api', 'prefix' => 'posts'], function ($router) {
    Route::get('/createposts', [CategoriesController::class, 'createPosts']);
});
