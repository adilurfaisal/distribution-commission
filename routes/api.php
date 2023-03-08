<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\TransactionController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group( function () {
    Route::get('profile', [UserController::class, 'show'])->middleware('rules:1,2,3,4');
    Route::get('user-list', [UserController::class, 'index'])->middleware('rules:1,2,3');
    Route::post('create-account', [UserController::class, 'store'])->middleware('rules:1,2');
    Route::delete('delete-account', [UserController::class, 'destroy'])->middleware('rules:1');
    Route::post('add-money', [TransactionController::class, 'store'])->middleware('rules:4');
    Route::get('transaction', [TransactionController::class, 'index'])->middleware('rules:4');
    Route::get('transaction/{user_id}', [TransactionController::class, 'show'])->middleware('rules:1');
    Route::get('commission', [CommissionController::class, 'index'])->middleware('rules:2,3');
    Route::get('commission/{user_id}', [CommissionController::class, 'show'])->middleware('rules:1');
});

Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login');
    Route::post('register', 'register');
})->middleware('throttle:1,1');;
