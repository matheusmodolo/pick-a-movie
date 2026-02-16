<?php

use App\Http\Controllers\OmdbController;
use Illuminate\Support\Facades\Route;

Route::get('/omdb/search', [OmdbController::class, 'search']);
Route::get('/omdb/details/{id}', [OmdbController::class, 'details']);
Route::get('/teste', function () {
    return response()->json(['message' => 'Teste OK']);
});
