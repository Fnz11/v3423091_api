<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('../../css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
    @stack('styles') <!-- Add this line before scripts -->
    @stack('scripts') <!-- Add this line to allow script injection -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .content-wrapper {
            perspective: 1000px;
            transform-style: preserve-3d;
            will-change: transform;
        }
    </style>
</head>

<body class="h-full bg-gradient-to-br from-gray-50 to-white">
    <div class="flex min-h-screen">
        @include('partials.admin.sidebar')

        <main class="flex-1 content-wrapper ml-72">
            <div class="mx-2 sm:mx-4 md:mx-6 my-4 px-4 py-2">
                <x-admin.nav-header :title="$__env->yieldContent('page-title', 'Dashboard')" />
                
                <div class="grid gap-6">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <style>
        .content-wrapper {
            perspective: 1000px;
            transform-style: preserve-3d;
        }
    </style>
</body>

</html>
