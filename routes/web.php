<?php

use App\Http\Controllers\UserMovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('lista');
    } else {
        return view('welcome');
    }
})->name('home');

Route::get('/about', function () {
    return view('auth.passwords.reset');
})->name('about');

Auth::routes();

Route::get('/lista', [App\Http\Controllers\HomeController::class, 'lista'])->name('lista');

Route::resource('user-movies', UserMovieController::class)->only(['index', 'store', 'update', 'destroy']);
