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

Route::get('v1/orders',         [\App\Http\Controllers\OrdenesController::class, 'index']);
Route::post('v1/orders',        [\App\Http\Controllers\OrdenesController::class, 'store']);
Route::delete('v1/orders/{id}', [\App\Http\Controllers\OrdenesController::class, 'destroy']);
Route::get('v1/orders/new',     [\App\Http\Controllers\OrdenesController::class, 'newOrder']);
Route::put('v1/orders/{id}/status',     [\App\Http\Controllers\OrdenesController::class, 'updateOrder']);



Route::get('v1/plates',     [\App\Http\Controllers\PlatesController::class, 'index']);
Route::post('v1/plates',    [\App\Http\Controllers\PlatesController::class, 'store']);
Route::put('v1/plates',     [\App\Http\Controllers\PlatesController::class, 'update']);