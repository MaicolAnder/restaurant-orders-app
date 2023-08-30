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

Route::get('v1/orders',         [\App\Http\Controllers\OrdenesController::class, 'index']); // Listar orden
Route::get('v1/orders/{id}',         [\App\Http\Controllers\OrdenesController::class, 'show']); // Obtiene order por id
Route::get('v1/orders/status/{id}', [\App\Http\Controllers\OrdenesController::class, 'index']); // Listar orden
Route::post('v1/orders',        [\App\Http\Controllers\OrdenesController::class, 'newOrder']); // Crear orden
Route::put('v1/orders/{id}',    [\App\Http\Controllers\OrdenesController::class, 'update']); // Tomar orden

Route::get('v1/orders/recipes/ingredients', [\App\Http\Controllers\RecipesController::class, 'recipesWithIngredientsDetail']); // Listar orden