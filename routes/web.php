<?php

use App\Http\Controllers\UserMovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('pesquisa');
    } else {
        return view('welcome');
    }
})->name('home');

Route::get('/about', function () {
    return view('auth.passwords.reset');
})->name('about');

Auth::routes();

Route::get('/buscar', [App\Http\Controllers\HomeController::class, 'pesquisa'])->name('pesquisa');
Route::get('/lista', [App\Http\Controllers\HomeController::class, 'pesquisa'])->name('lista');

Route::resource('user-movies', UserMovieController::class)->only(['index', 'store', 'update', 'destroy']);
