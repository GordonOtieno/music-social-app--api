<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->group(function(){
//     Route::get('inside-mware', function(){
//         return response()->json('success', 200);
//     });
// });
Route::group(['prefix'=>'v1'],function(){
  Route::post('/auth/register',[AuthController::class,'register']);
  Route::post('/auth/login',[AuthController::class,'login']);
  Route::get('/users/{id}',[UserController::class,'show']);
  Route::put('/users/{id}',[UserController::class,'update'])->middleware('auth:sanctum');
  Route::post('/auth/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
});