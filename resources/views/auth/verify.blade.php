@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Enhanced Background with verify-specific colors -->
        <div class="fixed inset-0 z-0">
            <div class="absolute inset-0 bg-premium-pattern"></div>
            <div class="absolute inset-0 backdrop-blur-[100px]"></div>
            <!-- Animated shapes specific to verify -->
            <div
                class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-br from-emerald-500/10 to-teal-500/10 rounded-full mix-blend-multiply filter blur-2xl animate-pulse">
            </div>
            <div
                class="absolute bottom-20 right-20 w-72 h-72 bg-gradient-to-br from-cyan-500/10 to-blue-500/10 rounded-full mix-blend-multiply filter blur-2xl animate-pulse delay-1000">
            </div>
        </div>

        <!-- Loading Overlay -->
        <div id="loadingOverlay" class="loading-overlay flex items-center justify-center">
            <div class="text-center">
                <div class="loading-spinner mx-auto mb-4">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <p class="text-slate-600 font-medium animate-pulse">Verifying your email...</p>
            </div>
        </div>

        <!-- Content Container -->
        <div class="relative z-10 w-full max-w-md px-4 cinematic-reveal">
            <div class="glass-morphism rounded-2xl p-8 sm:p-12">
                <!-- Logo & Title -->
                <div class="text-center mb-8 space-y-4">
                    <div class="relative inline-flex">
                        <div
                            class="absolute inset-0 bg-gradient-to-tr from-emerald-500/20 to-teal-500/20 blur-2xl rounded-full">
                        </div>
                        <div
                            class="relative w-20 h-20 gradient-primary rounded-2xl shadow-xl flex items-center justify-center transform hover:scale-105 transition-all duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-800 bg-clip-text text-transparent">
                        Verify Your Email</h1>
                    <p class="text-slate-600">We've sent a code to {{ $email }}</p>
                </div>

                <!-- OTP Input -->
                <form method="POST" action="{{ route('verify.verify') }}" class="space-y-6" id="verifyForm">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="space-y-4">
                        <input type="hidden" id="fullOtp" name="otp">
                        <div class="flex justify-center gap-2">
                            @for ($i = 1; $i <= 6; $i++)
                                <input type="text" id="otp-{{ $i }}" maxlength="1" pattern="[0-9]*"
                                    inputmode="numeric"
                                    class="w-12 h-12 text-center text-2xl font-semibold bg-white/70 shadow-lg border border-slate-200 rounded-lg 
                                      focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500/50 
                                      transition-all duration-200 cursor-pointer
                                      hover:shadow-purple-500/10"
                                    onclick="this.select()" data-index="{{ $i }}">
                            @endfor
                        </div>
                    </div>

                    <div id="error-message" class="hidden mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
                        <p class="text-sm text-red-600"></p>
                    </div>

                    <button type="submit" id="submitBtn"
                        class="btn-loading-state relative w-full inline-flex items-center justify-center px-6 py-4 text-base font-medium text-white gradient-primary rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transform transition-all duration-200 hover:shadow-[0_0_20px_-3px_rgba(0,0,0,0.2)] hover:-translate-y-0.5">
                        <span class="button-content flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Verify Email</span>
                        </span>
                        <span class="loading-indicator">
                            <div class="loading-dots-premium inline-flex space-x-1">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </span>
                    </button>
                </form>

                <!-- Resend Link -->
                <div class="mt-8 text-center">
                    <form action="{{ route('verify.resend') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <button type="submit" class="text-sm text-slate-600 hover:text-emerald-600 transition-colors">
                            Didn't receive the code? <span class="font-semibold underline">Resend</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const otpInputs = document.querySelectorAll('[id^="otp-"]');
            const fullOtpInput = document.getElementById('fullOtp');

            // Handle paste event for the whole document
            document.addEventListener('paste', (e) => {
                const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                const numbers = pastedText.replace(/\D/g, '').slice(0, 6).split('');

                otpInputs.forEach((input, index) => {
                    if (numbers[index]) {
                        input.value = numbers[index];
                        input.dispatchEvent(new Event('input'));
                    }
                });

                if (numbers.length > 0) {
                    otpInputs[Math.min(numbers.length, 5)].focus();
                }

                e.preventDefault();
            });

            // Handle input for each OTP field
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    const value = e.target.value;

                    // Only allow numbers
                    if (!/^\d*$/.test(value)) {
                        input.value = '';
                        return;
                    }

                    if (value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }

                    // Update hidden input with full OTP
                    fullOtpInput.value = Array.from(otpInputs).map(input => input.value).join('');
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });

            document.getElementById('verifyForm').addEventListener('submit', async function(event) {
                event.preventDefault(); // Prevent the default form submission

                const submitBtn = document.getElementById('submitBtn');
                const errorMessage = document.getElementById('error-message');
                const loadingOverlay = document.getElementById('loadingOverlay');
                errorMessage.classList.add('hidden'); // Hide any previous error message

                // Show loading state
                loadingOverlay.style.display = 'flex';
                submitBtn.disabled = true;

                // Collect form data
                const formData = new FormData(this);
                const fullOtp = Array.from({
                    length: 6
                }, (_, i) => document.getElementById(`otp-${i + 1}`).value).join('');
                formData.set('otp', fullOtp);

                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')
                                .value,
                        },
                    });

                    const result = await response.json();

                    if (response.ok) {
                        // Save the token in localStorage
                        localStorage.setItem('token', result.token);

                        // Redirect to the specified path
                        window.location.href = result.redirect;
                    } else {
                        // Show error message
                        errorMessage.classList.remove('hidden');
                        errorMessage.querySelector('p').innerText = result.error ||
                            'An error occurred. Please try again.';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    errorMessage.classList.remove('hidden');
                    errorMessage.querySelector('p').innerText = 'An error occurred. Please try again.';
                } finally {
                    // Hide loading state
                    loadingOverlay.style.display = 'none';
                    submitBtn.disabled = false;
                }
            });
        });
    </script>
@endsection
