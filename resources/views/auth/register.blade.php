@extends('layouts.auth')

@section('content')
    <div class="max-w-xl w-full mx-auto gradient-transparent shadow-2xl rounded-2xl p-8 mt-20">
        <div class="text-center text-3xl font-bold text-gray-800 mb-8">{{ __('Register') }}</div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid md:grid-cols-2 gap-4">
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 font-semibold">{{ __('Name') }}</label>
                    <input placeholder="Enter name here" id="name" type="text" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus
                        class=" @error('name') border-red-500 @enderror">
                    @error('name')
                        <span class="text-red-500 text-sm mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-semibold">{{ __('Email Address') }}</label>
                    <input placeholder="Enter email here" id="email" type="email" name="email"
                        value="{{ old('email') }}" required autocomplete="email"
                        class=" @error('email') border-red-500 @enderror">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-semibold">{{ __('Password') }}</label>
                    <input placeholder="Enter password here" id="password" type="password" name="password" required
                        autocomplete="new-password" class=" @error('password') border-red-500 @enderror">
                    @error('password')
                        <span class="text-red-500 text-sm mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password-confirm"
                        class="block text-gray-700 font-semibold">{{ __('Confirm Password') }}</label>
                    <input placeholder="Confirm password here" id="password-confirm" type="password"
                        name="password_confirmation" required autocomplete="new-password" class="">
                </div>
            </div>

            <div class="mb-6 flex flex-col gap-3">
                <button type="submit" class="btn-primary w-full">
                    {{ __('Register') }}
                </button>
                <a class="btn-outline w-full" href="{{ route('login') }}">
                    {{ __('Login') }}
                </a>
            </div>
        </form>
    </div>
@endsection
