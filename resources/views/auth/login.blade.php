@extends('layouts.auth')

@section('content')
    <div class="max-w-lg w-full mx-auto gradient-transparent shadow-2xl rounded-2xl p-8 mt-10">
        <div class="text-center text-3xl font-bold text-gray-800 mb-8">{{ __('Login') }}</div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-6">
                <label for="email" class="block text-gray-700 font-semibold">{{ __('Email Address') }}</label>
                <input id="email" type="email" placeholder="Enter email here"
                    class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="text-red-500 text-sm mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-semibold">{{ __('Password') }}</label>
                <input id="password" type="password" placeholder="Enter password here"
                    class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror"
                    name="password" required autocomplete="current-password">
                @error('password')
                    <span class="text-red-500 text-sm mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-6 flex items-center">
                <input class="form-checkbox h-4 w-4 text-purple-600 transition duration-150 ease-in-out" type="checkbox"
                    name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="ml-2 block text-gray-900 font-semibold" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <div class="mb-6 flex flex-col gap-3">
                <button type="submit" class="btn-primary w-full">
                    {{ __('Login') }}
                </button>
                <a class="btn-outline w-full" href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            </div>
        </form>
    </div>
@endsection
