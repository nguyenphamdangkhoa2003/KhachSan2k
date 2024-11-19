<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    {{-- PhotoSwipe --}}
    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5.4.3/dist/umd/photoswipe.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5.4.3/dist/umd/photoswipe-lightbox.umd.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/photoswipe@5.4.3/dist/photoswipe.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @cloudinaryJS
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-mary-nav sticky class="lg:hidden">
        <x-slot:brand>
            <div class="ml-5 pt-5">App</div>
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-mary-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-mary-nav>

    {{-- MAIN --}}
    <x-mary-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <a href="{{ route('home') }}" class="ml-5 pt-5">App</a>

            {{-- MENU --}}
            <x-mary-menu activate-by-route>
                {{-- User --}}
                @if ($user = auth()->user())
                    <x-mary-menu-separator />

                    <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                        class="-mx-2 !-my-2 rounded">
                        <x-slot:actions>
                            <x-mary-theme-toggle darkTheme="retro" lightTheme="cupcake" />
                        </x-slot:actions>
                    </x-mary-list-item>

                    <x-mary-menu-separator />
                @endif
                <x-mary-menu-item title="Type Room" icon="o-tag" link="{{ route('admin.dashboard.typeroom') }}" />
                <x-mary-menu-item title="Room" icon="o-square-3-stack-3d"
                    link="{{ route('admin.dashboard.room') }}" />
                <x-mary-menu-item title="User" icon="o-user" link="{{ route('admin.dashboard.user') }}" />
                <x-mary-menu-item title="Carousel" icon="o-square-2-stack"
                    link="{{ route('admin.dashboard.carousels') }}" />
                <x-mary-menu-item title="Log out" icon="o-power" link="{{ route('logout') }}" />
            </x-mary-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-mary-main>

    {{-- Toast --}}
    <x-mary-toast />
</body>

</html>
