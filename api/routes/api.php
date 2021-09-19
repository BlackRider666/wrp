<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\OrganizerController;
use App\Http\Controllers\API\PartnerController;

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
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [ AuthController::class, 'login']);
    Route::post('register', [ AuthController::class, 'register']);
    Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [ AuthController::class, 'user']);
        Route::post('update', [ AuthController::class, 'update']);
        Route::post('update-photo', [ AuthController::class, 'updatePhoto']);
        Route::post('change-password', [ AuthController::class, 'changePassword']);
    });
    Route::post('logout', [ AuthController::class, 'logout'])->middleware('auth:sanctum');
});
Route::get('news',[NewsController::class, 'index']);
Route::get('organizers',[OrganizerController::class, 'index']);
Route::get('partners',[PartnerController::class, 'index']);
