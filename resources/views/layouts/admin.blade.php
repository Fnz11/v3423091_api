<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('../../css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/css/app.css')
</head>

<body>
    <div class="flex bg-slate-100">
        <!-- Sidebar -->
        @include('partials.admin.sidebar')

        <!-- Page Content -->
        <div class="w-full flex flex-col gap-3 p-3">
            <header class="w-full flex justify-between gap-2 py-3 px-4">
                <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="font-medium text-lg hover:underline">Logout</button>
                </form>
            </header>

            <!-- Main Content Area -->
            @yield('content')
        </div>
    </div>
</body>

</html>
