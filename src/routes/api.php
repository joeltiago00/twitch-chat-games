<?php

use App\Http\Controllers\Auth\LoginWithTwitchController;
use App\Http\Controllers\Duel\CreateDuelController;
use App\Http\Controllers\Duel\CreateNewDuelRoundController;
use App\Http\Controllers\Duel\Round\RoundPlayController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'duel'], function () {
    Route::post('', CreateDuelController::class);

    Route::group(['prefix' => '{duel}'], function () {
        Route::get('new-round', CreateNewDuelRoundController::class);

        Route::get('round/{round}/play', RoundPlayController::class);
    });
});

Route::get('logged', fn() => response()->json(['message' => 'logged with twitch!']));

Route::get('twitch-auth', LoginWithTwitchController::class);
