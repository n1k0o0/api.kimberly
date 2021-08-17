<?php

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

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
//    Route::post('token', 'LoginController@token');

    Route::post("me", '\App\Http\Controllers\Auth\MeController')
        ->middleware(["auth:sanctum"]);
});
Route::middleware(['guest:internal_users'])->group(function () {

});
Route::middleware(['auth:internal_users'])->group(function () {
    Route::prefix('/notifications')->group(function () {

    });
    Route::prefix('/leagues')->group(function () {

    });
    Route::prefix('/tables')->group(function () {

    });
    Route::prefix('/calendar')->group(function () {

    });
});
Route::middleware(['guest:users'])->group(function () {
    Route::prefix('schools')->group(function () {

    });
});
Route::middleware(['auth:users'])->group(function () {
    Route::prefix('/')->group(function () {

    });
});

Route::prefix('countries')->group(function () {
    Route::apiResource('/', \App\Http\Controllers\CountryController::class);
});
Route::prefix('cities')->group(function () {
    Route::apiResource('/', \App\Http\Controllers\CityController::class);
});
Route::prefix('stadiums')->group(function () {
    Route::apiResource('/', \App\Http\Controllers\StadiumController::class);
});
