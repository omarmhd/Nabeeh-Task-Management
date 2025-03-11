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

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register'])->name("api.register");
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name("api.login");

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->name("api.logout");;
    Route::apiResource('tasks', \App\Http\Controllers\Api\TaskController::class);

});
