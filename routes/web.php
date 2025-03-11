<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('tasks.index');
    });
    Route::get("tasks", [TaskController::class, "index"])->name("web.tasks.index");
});
//
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'loginPage'])->name('login');
