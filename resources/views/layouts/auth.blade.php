<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth - @yield('title')</title>
    @vite('resources/css/app.css')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Add this for debugging -->
    <script>
        console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.content);
    </script>
</head>

<body>
    <div class="auth-container">
        @yield('content')
    </div>
</body>

</html>
