<?php

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
