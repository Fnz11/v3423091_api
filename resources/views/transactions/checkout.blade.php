@extends('layouts.admin')

@section('title', 'Checkout')

@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        .animate-scaleIn {
            animation: scaleIn 0.6s ease-out;
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-4xl font-bold mb-8 text-gray-800 tracking-tight">Checkout</h1>

        <div class="backdrop-blur-lg bg-white/70 rounded-3xl p-6 animate-scaleIn shadow-xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Order Summary -->
                <div class="bg-white/90 rounded-2xl p-6 animate-fadeIn shadow-sm">
                    <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
                        <i class="fas fa-shopping-bag text-blue-400"></i>
                        Order Summary
                    </h3>
                    <div class="space-y-4">
                        @foreach ($cart->items as $item)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset('storage/images/clothes/' . $item->clothes->image) }}"
                                        class="w-16 h-16 object-cover rounded-xl transition-transform duration-300 hover:scale-110 hover:rotate-2 shadow-md">
                                    <div>
                                        <h4 class="font-medium text-gray-800">{{ $item->clothes->name }}</h4>
                                        <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <p class="font-semibold text-gray-800">Rp {{ number_format($item->subtotal, 2) }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-xl flex justify-between items-center">
                            <span class="font-semibold text-gray-600">Total Amount:</span>
                            <span class="font-bold text-gray-800">Rp {{ number_format($cart->total_amount, 2) }}</span>
                        </p>
                    </div>
                </div>

                <!-- Checkout Form -->
                <div class="bg-white/90 rounded-2xl p-6 animate-fadeIn shadow-sm">
                    <form action="{{ route('user.transactions.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <!-- Payment Method -->
                            <div>
                                <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
                                    <i class="fas fa-credit-card text-green-400"></i>
                                    Payment Method
                                </h3>
                                <div class="relative group">
                                    <div
                                        class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000">
                                    </div>
                                    <div class="relative">
                                        <select name="payment_method" id="payment_method" required
                                            class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer">
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="e_wallet">E-Wallet</option>
                                        </select>
                                        <label for="payment_method"
                                            class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 left-2">
                                            Select Payment Method
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Address -->
                            <div>
                                <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
                                    <i class="fas fa-truck text-purple-400"></i>
                                    Shipping Address
                                </h3>
                                <div class="space-y-4">
                                    <!-- Street Address -->
                                    <div class="relative group">
                                        <div
                                            class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000">
                                        </div>
                                        <div class="relative">
                                            <input type="text" name="shipping_address[street]" id="street" required
                                                class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer">
                                            <label for="street"
                                                class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                                                Street Address
                                            </label>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <!-- City -->
                                        <div class="relative group">
                                            <div
                                                class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000">
                                            </div>
                                            <div class="relative">
                                                <input type="text" name="shipping_address[city]" id="city" required
                                                    class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer">
                                                <label for="city"
                                                    class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                                                    City
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Postal Code -->
                                        <div class="relative group">
                                            <div
                                                class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000">
                                            </div>
                                            <div class="relative">
                                                <input type="text" name="shipping_address[postal_code]" id="postal_code"
                                                    required
                                                    class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer">
                                                <label for="postal_code"
                                                    class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                                                    Postal Code
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-end gap-4 pt-6">
                                <a href="{{ route('cart.index') }}"
                                    class="relative inline-flex items-center justify-center px-6 py-3 text-base font-medium text-slate-700 bg-white hover:bg-slate-50 rounded-xl shadow-sm transition-all duration-200 hover:translate-y-[-2px] hover:shadow-md group">
                                    <span
                                        class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-xl blur opacity-0 group-hover:opacity-75 transition duration-1000"></span>
                                    <i class="fas fa-arrow-left text-slate-400 mr-2"></i>
                                    Back to Cart
                                </a>
                                <button type="submit"
                                    class="relative inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-gradient-to-r from-slate-800 to-slate-900 rounded-xl hover:from-slate-900 hover:to-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transform transition-all duration-200 hover:shadow-[0_0_20px_-3px_rgba(0,0,0,0.2)] hover:-translate-y-0.5">
                                    <i class="fas fa-check mr-2"></i>
                                    Place Order
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = getCookie('token') || localStorage.getItem('token');
            if (!token) {
                window.location.replace('/login');
                return;
            }

            // Add token to form submission
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.disabled = true;

                const formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        headers: { 
                            'Authorization': `Bearer ${token}`,
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            if (response.status === 401) {
                                localStorage.removeItem('token');
                                window.location.replace('/login');
                                throw new Error('Please login again');
                            }
                            throw new Error('Checkout failed');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            alert(data.message || 'Order created successfully!'); 
                        } else {
                            throw new Error(data.message || 'Checkout failed');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message);
                        submitBtn.disabled = false;
                    });
            });

            function getCookie(name) {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(';').shift();
            }
        });
    </script>
@endpush
