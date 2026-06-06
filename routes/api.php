<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

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

// Route bawaan Laravel untuk mengambil data user (butuh Sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route Midtrans untuk project js-rent lu
Route::post('/checkout', [CheckoutController::class, 'getToken']);
Route::post('/midtrans-notification', [CheckoutController::class, 'receiveNotification']);