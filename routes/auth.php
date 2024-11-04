<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Middleware\admin;
use App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('register', 'pages.auth.register')
        ->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Route::get('/auth/redirect/{provider}', [SocialAuthController::class, 'redirectToProvider'])
        ->where('provider', 'github|google|facebook')->name('socialite.redirect');

    Route::get('/auth/callback/{provider}', [SocialAuthController::class, 'handleProviderCallback'])
        ->where('provider', 'github|google|facebook')->name('socialite.callback');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
});

Route::middleware(['auth', admin::class])->group(function () {
    Route::get('admin/dashboard', Dashboard::class)->name('admin.dashboard');
});
