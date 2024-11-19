<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Middleware\admin;
use App\Livewire\Admin\Component\CarouselTable;
use App\Livewire\Pages\Admin\Component\CreateUser;
use App\Livewire\Pages\Admin\Component\RoomTable;
use App\Livewire\Pages\Admin\Component\RoomTypeTable;
use App\Livewire\Pages\Admin\Component\UserTable;
use App\Livewire\Pages\Admin\Dashboard;
use App\Livewire\Pages\Auth\Register;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('register', Register::class)
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

    Route::get("logout", function () {
        Auth::logout();
        return redirect(route("home"));
    })->name("logout");
});

Route::middleware(['auth', admin::class])->group(function () {
    Volt::route('admin/dashboard', Dashboard::class)->name('admin.dashboard');
    Volt::route('admin/dashboard/list-type-room', RoomTypeTable::class)->name('admin.dashboard.typeroom');
    Volt::route("admin/dashboard/list-room", RoomTable::class)->name("admin.dashboard.room");
    Volt::route("admin/dashboard/list-user", UserTable::class)->name("admin.dashboard.user");
    Volt::route("admin/dashboard/user/create", CreateUser::class)->name("admin.dashboard.user.create");
    Volt::route("admin/admin/dashboard/list-carousel", CarouselTable::class)->name("admin.dashboard.carousels");
});
