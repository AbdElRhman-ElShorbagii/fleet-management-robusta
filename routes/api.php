<?php

use App\Http\Controllers\Auth\APIAuthController;
use App\Http\Controllers\ReservationController;
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
// });

Route::post('register-user', [APIAuthController::class, 'register']);
Route::post('user-login', [APIAuthController::class, 'login']);

Route::group([ 'middleware'=>'auth:sanctum','abilities:user'], function() {
    Route::post('/logout', [APIAuthController::class, 'logout']);
    Route::prefix('reservation')->group(function () {
        Route::get('check-available-seat', [ReservationController::class, 'checkAvailableSeat']);
        Route::post('make-reservation', [ReservationController::class, 'makeReservation']);    
    });
    

});


