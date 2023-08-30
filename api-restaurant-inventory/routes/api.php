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

Route::get('v1/ingredients', [\App\Http\Controllers\IngredientesController::class, 'index']);
Route::get('v1/ingredients/{id_ingrediente}/show', [\App\Http\Controllers\IngredientesController::class, 'show']);
Route::get('v1/ingredients/inventory', [\App\Http\Controllers\IngredientesController::class, 'showInventoryIngredients']);
Route::get('v1/ingredients/inventory/{idIngredient}', [\App\Http\Controllers\IngredientesController::class, 'showInventoryIngredients']);
Route::get('v1/ingredients/inventory/{idIngredient}/status/{idStatus}', [\App\Http\Controllers\IngredientesController::class, 'showInventoryIngredients']);

Route::get('v1/ingredients/buy', [\App\Http\Controllers\RequestController::class, 'getBuysOnMarketplace']);
Route::get('v1/ingredients/buy/{tipo_movimiento}', [\App\Http\Controllers\RequestController::class, 'getBuysOnMarketplace']);
Route::post('v1/ingredients/buy/{ingredient}', [\App\Http\Controllers\RequestController::class, 'buyIngredient']);
