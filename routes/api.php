<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\SongController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\SongsByUserController;

Route::group(['prefix'=>'v1'],function(){
  Route::post('/auth/register',[AuthController::class,'register']);
  Route::post('/auth/login',[AuthController::class,'login']);
  Route::get('/users/{id}',[UserController::class,'show']);
  Route::put('/users/{id}',[UserController::class,'update'])->middleware('auth:sanctum');
  Route::post('/songs',[SongController::class,'store'])->middleware('auth:sanctum');
  Route::delete('/songs/{id}/{user_id}',[SongController::class,'destroy'])->middleware('auth:sanctum');
  Route::get('/user/{user_id}/songs',[SongsByUserController::class,'index'])->middleware('auth:sanctum');
  Route::post('/auth/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
});
