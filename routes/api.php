<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;

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

Route::group(['middleware' => 'auth:api', 'prefix' => 'posts'], function ($router) {
    Route::post('/createposts', [PostsController::class, 'createPosts']);
});

Route::group(['middleware' => 'api', 'prefix' => 'search'], function ($router) {
    Route::get('/searchuser', [UsersController::class, 'getusers']);
});

Route::group(['middleware' => 'api', 'prefix' => 'posts'], function ($router) {
    Route::get('/getposts', [PostsController::class, 'getHomePost']);
    Route::get('/userposts', [PostsController::class, 'getUserPost']);
    Route::get('/getsinglepost/{id}', [PostsController::class, 'getSinglePost']);
});

Route::group(['middleware' => 'api', 'prefix' => 'comments'], function ($router) {
    Route::post('/create', [CommentController::class, 'create']);
    Route::get('/getcomments/{id}', [CommentController::class, 'getcomments']);
});


Route::group(['middleware' => 'auth:api', 'prefix' => 'likeposts'], function ($router) {
    Route::post('/likes', [LikesController::class, 'AddremoveLikes']);
});
