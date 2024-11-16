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
    <x-mary-nav sticky full-width>

        <x-slot:brand>
            {{-- Drawer toggle for "main-drawer" --}}
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-mary-icon name="o-bars-3" class="cursor-pointer" />
            </label>

            {{-- Brand --}}
            <div>App</div>
        </x-slot:brand>

        {{-- Right side actions --}}
        <x-slot:actions>
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
        </x-slot:actions>
    </x-mary-nav>

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
