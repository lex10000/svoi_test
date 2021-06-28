<?php

use App\Http\Controllers\Api\RegisterController;
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

/**
 * Register user using sanctum
 */
Route::post('register', [RegisterController::class, 'register']);

/**
 * Login user using sanctum
 */
Route::post('login', [RegisterController::class, 'login']);

/**
 * Api for companies
 */
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('companies', \App\Http\Controllers\Api\CompanyController::class);
});

/**
 * Api for layouts
 */
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('layouts', \App\Http\Controllers\Api\LayoutController::class);
});

Route::fallback(function () {
    return response()->json(['not found']);
});
