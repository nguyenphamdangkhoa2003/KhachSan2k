<?php

use App\Livewire\Pages\Home;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/home', Home::class)->name("home");
Route::view("/", "welcome")->name("welcome");

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
