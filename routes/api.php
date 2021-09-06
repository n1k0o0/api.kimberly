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
Route::middleware(['auth:internal-users'])->group(function () {
    Route::prefix('/notifications')->group(function () {

    });
    Route::prefix('/tables')->group(function () {

    });
    Route::prefix('/calendar')->group(function () {

    });
});
Route::prefix('internal_users')->group(function () {
    Route::post('/me', [\App\Http\Controllers\InternalUserController::class, 'getMe']);
    Route::post('/issue-token', [\App\Http\Controllers\InternalUserController::class, 'issueToken']);
    Route::post('/revoke-token', [\App\Http\Controllers\InternalUserController::class, 'revokeToken']);
});
Route::apiResource('internal_users',\App\Http\Controllers\InternalUserController::class);

Route::prefix('/users')->group(function () {
//    Route::post('/me', [\App\Http\Controllers\UserController::class, 'getMe']);
    Route::post('/register', [\App\Http\Controllers\UserController::class, 'register']);
    Route::post('/issue-token', [\App\Http\Controllers\UserController::class, 'issueToken']);
    Route::post('/revoke-token', [\App\Http\Controllers\UserController::class, 'revokeToken']);
});
Route::apiResource('users',\App\Http\Controllers\UserController::class);

Route::middleware(['auth:users'])->group(function () {

});

Route::prefix('countries')->group(function () {
});
Route::apiResource('countries', \App\Http\Controllers\CountryController::class);

Route::prefix('cities')->group(function () {});
Route::apiResource('cities', \App\Http\Controllers\CityController::class);

Route::prefix('stadiums')->group(function () {});
Route::apiResource('stadiums', \App\Http\Controllers\StadiumController::class);

Route::apiResource('leagues', \App\Http\Controllers\LeagueController::class);

Route::apiResource('divisions', \App\Http\Controllers\DivisionController::class);

Route::prefix('tournaments')->group(function () {
    Route::prefix('{id}')->group(function () {
        Route::put('status', [\App\Http\Controllers\TournamentController::class, 'updateStatus']);
    });
    Route::get('/current', [\App\Http\Controllers\TournamentController::class, 'getCurrent']);
});
Route::apiResource('tournaments', \App\Http\Controllers\TournamentController::class);

Route::prefix('schools')->group(function () {
    Route::get('all', [\App\Http\Controllers\SchoolController::class, 'getAll']);
});
Route::apiResource('schools', \App\Http\Controllers\SchoolController::class);

Route::apiResource('teams', \App\Http\Controllers\TeamController::class);

Route::apiResource('coaches', \App\Http\Controllers\CoachController::class);

Route::apiResource('social-links', \App\Http\Controllers\SocialLinkController::class);

Route::post('/init', function () {});
