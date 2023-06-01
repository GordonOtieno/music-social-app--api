<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\SongController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\YoutubeController;
use App\Http\Controllers\Api\V1\SongsByUserController;


Route::group(['prefix'=>'v1'],function(){

  Route::post('/auth/register',[AuthController::class,'register']);
  Route::post('/auth/login',[AuthController::class,'login']);
  Route::get('/users/{id}',[UserController::class,'show']);
  Route::put('/users/{id}',[UserController::class,'update'])->middleware('auth:sanctum');
  
  Route::get('/youtube/{user_id}',[YoutubeController::class,'show'])->middleware('auth:sanctum');
  Route::post('/youtube',[YoutubeController::class,'store'])->middleware('auth:sanctum');
  Route::delete('/youtube/{id}',[YoutubeController::class,'destroy'])->middleware('auth:sanctum');

  Route::post('/songs',[SongController::class,'store'])->middleware('auth:sanctum');
  Route::delete('/songs/{id}/{user_id}',[SongController::class,'destroy'])->middleware('auth:sanctum');
  Route::get('/user/{user_id}/songs',[SongsByUserController::class,'index'])->middleware('auth:sanctum');
  
  Route::get('/posts',[PostController::class,'index'])->middleware('auth:sanctum');
  Route::get('/posts/{id}',[PostController::class,'show'])->middleware('auth:sanctum');
  Route::post('/posts',[PostController::class,'store'])->middleware('auth:sanctum');
  Route::put('/posts/{id}',[PostController::class,'update'])->middleware('auth:sanctum');
  Route::delete('/posts/{id}',[PostController::class,'destroy'])->middleware('auth:sanctum');
  
  Route::post('/auth/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
});
