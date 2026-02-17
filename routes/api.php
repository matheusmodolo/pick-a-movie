<?php

use App\Http\Controllers\OmdbController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


// Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);

// Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);

// Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);
// Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);

Route::group(['prefix' => 'omdb'], function () {
    Route::get('/search', [OmdbController::class, 'search']);
    Route::get('/details/{id}', [OmdbController::class, 'details']);
});
