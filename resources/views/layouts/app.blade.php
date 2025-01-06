<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Prestige Couture')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @layer utilities {
            .perspective-1000 {
                perspective: 1000px;
            }

            .preserve-3d {
                transform-style: preserve-3d;
            }
        }
    </style>
</head>

<body x-data="{ mobileMenu: false }">
    <x-nav.main-nav />

    <main class="min-h-screen">
        @yield('content')
    </main>

    <x-layout.footer />
</body>

</html>
