<?php

use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarModelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('cars/brands', CarBrandController::class)->except('store', 'update', 'destroy');
Route::apiResource('cars/models', CarModelController::class)->except('store', 'update', 'destroy');
Route::apiResource('cars', CarController::class)->except('store', 'update', 'destroy');
