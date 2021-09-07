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
Route::prefix('internal_users')->group(function () {
    Route::post('/issue-token', [\App\Http\Controllers\Admin\AuthInternalUserController::class, 'issueToken']);
});
Route::middleware(['auth:internal-users'])->group(function () {
    Route::prefix('internal_users')->group(function () {
//        Route::post('/refresh-token', [\App\Http\Controllers\Admin\AuthInternalUserController::class, 'refreshToken']);
        Route::post('/revoke-token', [\App\Http\Controllers\Admin\AuthInternalUserController::class, 'revokeToken']);
    });
    Route::apiResource('internal_users',\App\Http\Controllers\Admin\InternalUserController::class);

    Route::prefix('countries')->group(function () {});
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
        Route::put('status', [\App\Http\Controllers\SchoolController::class, 'setStatus']);
    });
    Route::apiResource('schools', \App\Http\Controllers\SchoolController::class);

    Route::apiResource('teams', \App\Http\Controllers\TeamController::class);

    Route::apiResource('coaches', \App\Http\Controllers\CoachController::class);

    Route::apiResource('social-links', \App\Http\Controllers\SocialLinkController::class);

    Route::prefix('/notifications')->group(function () {});

    Route::prefix('/tables')->group(function () {});

    Route::prefix('/calendar')->group(function () {});
});

Route::prefix('users')->group(function () {
    Route::post('issue-token', [\App\Http\Controllers\Api\UserController::class, 'issueToken']);
    Route::post('register', [\App\Http\Controllers\Api\UserController::class, 'register']);
    Route::post('email/confirm', [\App\Http\Controllers\Api\UserController::class, 'confirmEmail']);
});
Route::middleware(['auth:users'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('revoke-token', [\App\Http\Controllers\Api\UserController::class, 'revokeToken']);
//        Route::post('/refresh-token', [\App\Http\Controllers\AuthUserController::class, 'refreshToken']);
    });
    Route::apiResource('users',\App\Http\Controllers\Api\UserController::class);
});
