<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ParcelController;
use App\Http\Controllers\Api\LogParcelController;

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

Route::middleware(['auth:sanctum'])->group( function () {
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/parcel', ParcelController::class);
    Route::apiResource('log-parcel', LogParcelController::class);
});
