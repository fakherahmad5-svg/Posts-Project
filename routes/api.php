<?php

use App\Http\Controllers\MainScreenController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(UserController::class)->group(function () {
    Route::post('register','register');
    Route::post('login','login');
    Route::get('logout','logout')->middleware('auth:sanctum');;
});

Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');

Route::get('post',[PostController::class,'index'])->middleware('auth:sanctum');

Route::apiResource('profile', ProfileController::class)->middleware('auth:sanctum');

Route::get('homePage',[MainScreenController::class,'index'])->middleware('auth:sanctum');
Route::get('homePage/like/{id}',[MainScreenController::class,'pressLike'])->middleware('auth:sanctum');
Route::get('homePage/dislike/{id}',[MainScreenController::class,'pressDislike'])->middleware('auth:sanctum');
