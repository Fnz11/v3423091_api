<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('../../css/app.css') }}">
    @vite('resources/css/app.css')
</head>

<body>
    <!-- Header -->
    <nav class="bg-white shadow-sm py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <a href="/" class="text-3xl font-bold tracking-wider text-gray-800">Prestige Couture</a>
            <div class="flex items-center gap-5">
                <ul>
                    <x-nav.nav-link href="#home">Home</x-nav.nav-link>
                </ul>
                <ul>
                    <x-nav.nav-link href="#about">About</x-nav.nav-link>
                </ul>
                <ul>
                    <x-nav.nav-link href="#products">Products</x-nav.nav-link>
                </ul>
                <ul>
                    <x-nav.nav-link href="#faq">FAQ</x-nav.nav-link>
                </ul>
                <a href="/login" class="btn-primary h-8">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <div class="w-full h-full">
        @yield('content')
    </div>
</body>

</html>
