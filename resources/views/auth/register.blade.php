@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Enhanced Background - Same as login -->
        <div class="fixed inset-0 z-0">
            <div class="absolute inset-0 bg-premium-pattern"></div>
            <div class="absolute inset-0 backdrop-blur-[100px]"></div>
            <!-- Animated shapes with different colors -->
            <div
                class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-br from-indigo-500/10 to-violet-500/10 rounded-full mix-blend-multiply filter blur-2xl animate-pulse">
            </div>
            <div
                class="absolute bottom-20 right-20 w-72 h-72 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-full mix-blend-multiply filter blur-2xl animate-pulse delay-1000">
            </div>
        </div>

        <!-- Content Container -->
        <div class="relative z-10 w-full max-w-xl px-4 cinematic-reveal">
            <div class="glass-morphism rounded-2xl p-8 sm:p-12">
                <!-- Logo & Title -->
                <div class="text-center mb-8 space-y-4">
                    <div class="relative inline-flex">
                        <div
                            class="absolute inset-0 bg-gradient-to-tr from-indigo-500/20 to-purple-500/20 blur-2xl rounded-full">
                        </div>
                        <div
                            class="relative inline-flex items-center justify-center w-20 h-20 gradient-primary rounded-2xl shadow-xl">
                            <svg class="w-10 h-10 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-slate-900 text-shadow-premium">Create Account</h1>
                    <p class="text-slate-600">Join our community</p>
                </div>

                <form id="registerForm" method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name Input -->
                        <div class="relative group">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000">
                            </div>
                            <div class="relative">
                                <input type="text" name="name" id="name" required
                                    class="block w-full px-5 py-4 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer"
                                    placeholder="Your name">
                                <label for="name"
                                    class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                                    Full Name
                                </label>
                            </div>
                        </div>

                        <!-- Email Input -->
                        <div class="relative group">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000">
                            </div>
                            <div class="relative">
                                <input type="email" name="email" id="email" required
                                    class="block w-full px-5 py-4 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer"
                                    placeholder="Your email">
                                <label for="email"
                                    class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                                    Email Address
                                </label>
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="relative group">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000">
                            </div>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                    class="block w-full px-5 py-4 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer"
                                    placeholder="Your password">
                                <label for="password"
                                    class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                                    Password
                                </label>
                            </div>
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="relative group">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000">
                            </div>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="block w-full px-5 py-4 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer"
                                    placeholder="Confirm password">
                                <label for="password_confirmation"
                                    class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                                    Confirm Password
                                </label>
                            </div>
                        </div>

                        <!-- ReCaptcha -->
                        <div class="flex justify-center p-4 bg-white/50 rounded-lg border border-slate-200/70 shadow-sm">
                            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="text-red-500 text-sm mt-1">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn"
                            class="btn-loading-state relative w-full inline-flex items-center justify-center px-6 py-4 text-base font-medium text-white gradient-primary rounded-xl transform transition-all duration-200">
                            <span class="button-content">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Create Account</span>
                            </span>
                            <span class="loading-indicator">
                                <div class="loading-dots-premium inline-flex space-x-1">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Login link -->
                <p class="mt-8 text-center text-sm text-slate-500">
                    Already have an account?
                    <a href="{{ route('login') }}"
                        class="font-semibold text-slate-800 hover:text-slate-900 focus:outline-none hover:underline transition duration-200">
                        Sign in
                    </a>
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelector('.cinematic-reveal').classList.add('opacity-100');
            });

            document.getElementById('registerForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');

                try {
                    const formData = new FormData(this);
                    const response = await fetch('/register', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    });

                    const data = await response.json();
                    console.log('Response data:', data);
                    return data;
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('loading');
                    grecaptcha.reset();
                    return null;
                }
            });
        </script>
    @endpush
@endsection
