<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shop</title>
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
    @vite('resources/css/app.css')
</head>

<body
    class="min-h-screen flex flex-col items-center justify-center w-full gradient-primary">
    <main class="container mx-auto py-6 px-4">
        @yield('content')
    </main>

    <footer class="text-white mb-3 mt-auto flex flex-col items-center justify-center gap-3">
        <div class="flex gap-5">
            <ul>
                <x-nav.footer-link href="/home">Home</x-nav.footer-link>
            </ul>
            <ul>
                <x-nav.footer-link href="/about">About</x-nav.footer-link>
            </ul>
            <ul>
                <x-nav.footer-link href="/products">Products</x-nav.footer-link>
            </ul>
            <ul>
                <x-nav.footer-link href="/faq">FAQ</x-nav.footer-link>
            </ul>
        </div>
        <p class="">&copy; 2024 Online Shop</p>
    </footer>
</body>

</html>
