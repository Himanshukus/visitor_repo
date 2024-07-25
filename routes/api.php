<?php

use App\Http\Controllers\ApiController;
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
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['checkdevice'])->group(function () {

    Route::post('visitcode', [ApiController::class, 'visitcode'])->name('visitcode');
    Route::post('takephoto', [ApiController::class, 'takephoto'])->name('takephoto');
    Route::post('genrate_badge', [ApiController::class, 'genrate_badge'])->name('genrate_badge');

    // group checkIn
    Route::post('groupcheckin', [ApiController::class, 'groupcheckin'])->name('groupcheckin');


    // for walk-in visitor
    Route::post('walkinvisitor', [ApiController::class, 'walkinvisitor'])->name('walkinvisitor');

    // for getting all the staff
    Route::get('getallstaff', [ApiController::class, 'getallstaff'])->name('getallstaff');

    Route::get('purposefield', [ApiController::class, 'purposefield'])->name('purposefield');

    // settings
    Route::get('settings', [ApiController::class, 'settings'])->name('settings');
});
