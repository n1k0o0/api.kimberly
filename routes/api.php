<?php

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
Route::prefix('dashboard')->group(function () {
    Route::prefix('internal_users')->group(function () {
        Route::post('/issue-token', [\App\Http\Controllers\Dashboard\AuthInternalUserController::class, 'issueToken']);
    });
    Route::middleware(['auth:internal-users'])->group(function () {
        Route::prefix('internal_users')->group(function () {
            Route::post('revoke-token', [\App\Http\Controllers\Dashboard\AuthInternalUserController::class, 'revokeToken']);
            Route::post('me', [\App\Http\Controllers\Dashboard\AuthInternalUserController::class, 'getMe']);
        });
        Route::apiResource('internal_users', \App\Http\Controllers\Dashboard\InternalUserController::class);
        Route::prefix('users')->group(function () {
        });
        Route::apiResource('users', \App\Http\Controllers\Dashboard\UserController::class)->only('index', 'show', 'update');
        Route::apiResource('countries', \App\Http\Controllers\Dashboard\CountryController::class);
        Route::apiResource('cities', \App\Http\Controllers\Dashboard\CityController::class);
        Route::apiResource('stadiums', \App\Http\Controllers\Dashboard\StadiumController::class);
        Route::apiResource('leagues', \App\Http\Controllers\Dashboard\LeagueController::class);
        Route::apiResource('divisions', \App\Http\Controllers\Dashboard\DivisionController::class);
        Route::prefix('tournaments')->group(function () {
            Route::prefix('{id}')->group(function () {
                Route::put('status', [\App\Http\Controllers\Dashboard\TournamentController::class, 'updateStatus']);
            });
            Route::get('/current', [\App\Http\Controllers\Dashboard\TournamentController::class, 'getCurrent']);
        });
        Route::apiResource('tournaments', \App\Http\Controllers\Dashboard\TournamentController::class);
        Route::prefix('schools')->group(function () {
            Route::prefix('{id}')->group(function () {
                Route::put('status', [\App\Http\Controllers\Dashboard\SchoolController::class, 'setStatus']);
            });
        });
        Route::apiResource('schools', \App\Http\Controllers\Dashboard\SchoolController::class)->except('store');
        Route::apiResource('teams', \App\Http\Controllers\Dashboard\TeamController::class);
        Route::apiResource('coaches', \App\Http\Controllers\Dashboard\CoachController::class);
        Route::apiResource('social-links', \App\Http\Controllers\Dashboard\SocialLinkController::class);
        Route::prefix('/tables')->group(function () {
        });
    });
});

Route::prefix('users')->group(function () {
    Route::post('issue-token', [\App\Http\Controllers\Api\UserController::class, 'issueToken']);
    Route::post('register', [\App\Http\Controllers\Api\UserController::class, 'register']);
    Route::post('email/confirm', [\App\Http\Controllers\Api\UserController::class, 'confirmEmail']);
});
Route::middleware(['auth:users'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('revoke-token', [\App\Http\Controllers\Api\UserController::class, 'revokeToken']);
        Route::post('me', [\App\Http\Controllers\Api\UserController::class, 'getMe']);
    });
    Route::apiResource('users', \App\Http\Controllers\Api\UserController::class);

    Route::put('schools', [\App\Http\Controllers\Api\SchoolController::class, 'updateSchool']);
    Route::apiResource('schools', \App\Http\Controllers\Api\SchoolController::class);
});
