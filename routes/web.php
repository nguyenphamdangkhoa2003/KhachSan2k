<?php

use Illuminate\Support\Facades\Route;

Route::view('/home', 'home')->name("home");
Route::view("/", "welcome")->name("welcome");

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
