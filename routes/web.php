<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\VisitorController;
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

Route::get('/login', [Authcontroller::class, 'login'])->name('login')->middleware('guest');
Route::post('loginPost', [Authcontroller::class, 'loginPost'])->name('loginPost');

Route::group(['prefix' => 'visitor', 'middleware' => 'auth'], function () {
    Route::get('/', [VisitorController::class, 'index'])->name('dashboard');
});



