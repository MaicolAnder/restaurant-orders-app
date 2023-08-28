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

Route::get('v1/status', [\App\Http\Controllers\StatusController::class, 'index']);
Route::get('v1/status/{id}', [\App\Http\Controllers\StatusController::class, 'show']);
Route::post('v1/status', [\App\Http\Controllers\StatusController::class, 'store']);
Route::put('v1/status/{id}', [\App\Http\Controllers\StatusController::class, 'update']);