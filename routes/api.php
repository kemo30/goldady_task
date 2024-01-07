<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\PostController;

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
//aith routes
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::middleware('auth:sanctum')->group(function(){
 Route::apiResource('categories',CategoriesController::class)->only(['store', 'update', 'destroy']);
 Route::apiResource('posts',PostController::class)->only(['store', 'update', 'destroy']);
});

//for overwrite routes inside apiResource function to maket it Unauthenticated
route::get('/categories',[CategoriesController::class,'index']);
route::get('/categories/{category}',[CategoriesController::class,'show']);

route::get('/posts',[PostController::class,'index']);
route::get('/posts/{post}',[PostController::class,'show']);
