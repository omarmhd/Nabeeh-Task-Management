<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

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

Route::middleware(['web_auth'])->group(function () {
    Route::get("tasks", [\App\Http\Controllers\TaskController::class, "index"])->name("web.tasks.index");
    Route::get('/', function () {
        return view('tasks.index');
    });
});
Route::post('/store-token', function (Request $request) {
    $token = $request->token;
    if ($token) {
        Session::put('auth_token', $token);
        return response()->json(['message' => 'Token stored in session.']);
    }
    return response()->json(['error' => 'Token is missing'], 400);
})->name('web.storeToken');
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'loginPage'])->name('login');
