<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    {{-- The navbar with `sticky` and `full-width` --}}
    <div class="navbar bg-base-100 z-50 sticky top-0 shadow-sm">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                    <li><a href="{{ route('home') }}">Trang Chủ</a></li>
                    <li><a href="{{ route('home') }}">Đặt Phòng</a></li>
                </ul>
            </div>
            <a class="btn btn-ghost text-xl">daisyUI</a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="{{ route('home') }}">Trang Chủ</a></li>
                <li><a href="{{ route('home') }}">Đặt Phòng</a></li>
            </ul>
        </div>
        <div class="navbar-end">
            <x-mary-theme-toggle darkTheme="retro" lightTheme="cupcake" />
            @auth
                <x-mary-dropdown label="{{ Auth::user()->name }}">
                    <x-mary-menu-item title="Profile" icon="o-user-circle" link="{{ route('profile') }}" />
                    @if (Auth::user()->is_admin)
                        <x-mary-menu-item title="Dashboard" icon="o-chart-bar" link="{{ route('admin.dashboard') }}" />
                    @endif('admin')

                    <x-mary-menu-item title="Log out" icon="c-power" link="{{ route('logout') }}" />

                </x-mary-dropdown>
            @else
                <x-mary-button label="Login" link="{{ route('login') }}" class="btn-ghost btn-sm" responsive />
                <x-mary-button label="Register" link="{{ route('register') }}" class="btn-ghost btn-sm" responsive />
            @endauth
        </div>
    </div>

    {{-- The main content with `full-width` --}}
    <x-mary-main with-nav full-width>

        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-mary-main>

    <x-mary-toast />
</body>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</html>
