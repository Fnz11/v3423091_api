@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Enhanced Background -->
        <div class="fixed inset-0 z-0">
            <div class="absolute inset-0 bg-premium-pattern"></div>
            <div class="absolute inset-0 backdrop-blur-[100px]"></div>
            <!-- Animated shapes -->
            <div
                class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-full mix-blend-multiply filter blur-2xl animate-pulse">
            </div>
            <div
                class="absolute bottom-20 right-20 w-72 h-72 bg-gradient-to-br from-blue-500/10 to-slate-500/10 rounded-full mix-blend-multiply filter blur-2xl animate-pulse delay-1000">
            </div>
        </div>

        <!-- Add this right after the opening body tag -->
        <div id="loadingOverlay" class="loading-overlay flex items-center justify-center">
            <div class="text-center">
                <div class="loading-spinner mx-auto mb-4">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <p class="text-slate-600 font-medium animate-pulse">Signing you in...</p>
            </div>
        </div>

        <!-- Content Container -->
        <div class="relative z-10 w-full max-w-xl px-4 cinematic-reveal">
            <div class="glass-morphism rounded-2xl p-8 sm:p-12">
                <!-- Logo & Title -->
                <div class="text-center mb-8 space-y-4">
                    <div class="relative inline-flex">
                        <div class="absolute inset-0 rounded-full">
                        </div>
                        <div
                            class="relative w-20 h-20 gradient-primary rounded-2xl shadow-2xl flex items-center justify-center transform hover:scale-105 transition-all duration-300">
                            <svg class="w-12 h-12 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-slate-900 text-shadow-premium">Welcome Back</h1>
                    <p class="text-slate-600">Sign in to your account</p>
                </div>

                <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Email Input -->
                        <div class="relative group">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000">
                            </div>
                            <div class="relative">
                                <input type="email" name="email" id="email" required value="{{ old('email') }}"
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

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" name="remember" id="remember"
                                    class="h-4 w-4 text-slate-900 focus:ring-slate-500 border-slate-300 rounded">
                                <label for="remember" class="ml-2 block text-sm text-slate-600">
                                    Remember me
                                </label>
                            </div>
                            {{-- <a href="{{ route('password.request') }}" class="text-sm font-semibold text-slate-800 hover:text-slate-900 hover:underline transition duration-200">
                        Forgot password?
                    </a> --}}
                        </div>

                        <!-- Enhanced submit button with loading state -->
                        <button type="submit" id="submitBtn"
                            class="btn-loading-state relative w-full inline-flex items-center justify-center px-6 py-4 text-base font-medium text-white gradient-primary rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transform transition-all duration-200 hover:shadow-[0_0_20px_-3px_rgba(0,0,0,0.2)] hover:-translate-y-0.5">
                            <span class="button-content">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                <span>Sign In</span>
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

                <!-- Enhanced register link -->
                <p class="mt-8 text-center text-sm text-slate-500">
                    Don't have an account?
                    <a href="{{ route('register') }}"
                        class="font-semibold text-slate-800 hover:text-slate-900 focus:outline-none hover:underline transition duration-200">
                        Create an account
                    </a>
                </p>

                <!-- Enhanced footer -->
                <div class="mt-6 pt-6 border-t border-slate-200/60">
                    <div class="flex items-center justify-center space-x-2">
                        <span class="flex h-2 w-2 relative">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-sm text-slate-500">Secure Authentication</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Add smooth reveal animation when page loads
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('.cinematic-reveal').classList.add('opacity-100');
            console.log("INI ADALAH TOKEN CSRF: ", document.querySelector('meta[name="csrf-token"]').content)
        });

        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.classList.add('loading'); // Add your loading state class

            try {
                const formData = new FormData();
                formData.append('email', document.getElementById('email').value);
                formData.append('password', document.getElementById('password').value);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                const response = await fetch('/login', {
                    method: 'POST',
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest' // Add this line
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    localStorage.setItem('token', data.token);
                    window.location.href = data.redirect;
                } else {
                    alert(data.error || 'Login failed');
                }
            } catch (error) {
                console.error('Login error:', error);
                alert('An error occurred during login. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.classList.remove('loading');
            }
        });
    </script>
@endsection
