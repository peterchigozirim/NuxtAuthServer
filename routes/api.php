<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MailController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ParcelController;
use App\Http\Controllers\Api\LogParcelController;
use App\Http\Controllers\Api\AppSettingController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\CreateUserController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);
Route::post('/get-otp', [UserController::class, 'resetOtp']);
Route::post('/get-tracking-number', [ParcelController::class, 'getTrackNumber']);
Route::post('/request-quote', [QuoteController::class, 'store']);
Route::post('/contact-us', [ContactController::class, 'store']);
Route::get('/app-details', [AppSettingController::class, 'index']);

Route::middleware(['auth:sanctum'])->group( function () {
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/parcel', ParcelController::class);
    Route::apiResource('log-parcel', LogParcelController::class);
    Route::apiResource('/mail', MailController::class);
    Route::apiResource('/manage-user', CreateUserController::class);
    Route::apiResource('/app-settings', AppSettingController::class);
    Route::apiResource('/quote', QuoteController::class);
    Route::apiResource('/contact', ContactController::class);

    Route::post('/change-password', [UserController::class, 'changePassword']);
    Route::post('/log-out', [AuthenticatedSessionController::class, 'destroy']);
});
