@extends('layouts.admin')

@section('title', $cloth->name)
@section('page-title', $cloth->name)

@push('styles')
    <style>
        .product-container {
            background: linear-gradient(135deg, #f8faff 0%, #f3f6fb 100%);
            position: relative;
            overflow: hidden;
        }

        .product-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
                    transparent 0%,
                    rgba(255, 255, 255, 0.1) 30%,
                    transparent 60%);
            animation: shine 8s infinite linear;
        }

        .glass-card {
            backdrop-filter: blur(16px);
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.8));
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.3) inset;
        }

        .floating-card {
            transform-style: preserve-3d;
            transition: transform 0.3s ease;
        }

        .floating-card:hover {
            transform: translateZ(20px) rotateX(2deg) rotateY(2deg);
        }

        @keyframes shine {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .price-tag {
            position: relative;
            overflow: hidden;
            @apply gradient-gold text-white py-3 px-6 rounded-xl;
            transform: skew(-10deg);
        }

        .price-tag span {
            display: inline-block;
            transform: skew(10deg);
        }

        .product-title {
            @apply gradient-dark bg-clip-text text-transparent;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .size-chip {
            @apply gradient-transparent backdrop-blur-sm px-4 py-2 rounded-full shadow-lg hover:shadow-xl transition-all duration-300;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .color-chip {
            @apply gradient-secondary text-white px-4 py-2 rounded-full shadow-lg hover:shadow-xl transition-all duration-300;
        }

        .quantity-control {
            @apply gradient-transparent backdrop-blur-md;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .add-to-cart-btn {
            @apply gradient-primary text-white;
            box-shadow:
                0 10px 20px -5px rgba(147, 51, 234, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.2) inset;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="overflow-hidden floating-card">
                <div class="flex flex-col lg:flex-row gap-12 p-10">
                    <!-- Product Image Section -->
                    <div class="w-full lg:w-1/2">
                        <div class="group relative hover-lift rounded-2xl overflow-hidden shadow-2xl">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <img src="{{ asset('storage/images/clothes/' . $cloth->image) }}" alt="{{ $cloth->name }}"
                                class="w-full h-[700px] object-cover transform-gpu transition-transform duration-700 hover:scale-105"
                                loading="lazy">
                        </div>
                    </div>

                    <!-- Product Details Section -->
                    <div class="w-full lg:w-1/2 flex flex-col justify-between space-y-8">
                        <div class="space-y-8">
                            <h1 class="product-title text-5xl md:text-6xl font-bold">
                                {{ $cloth->name }}
                            </h1>

                            <div class="price-tag inline-block">
                                <span class="text-3xl font-bold">
                                    Rp {{ number_format($cloth->price, 2) }}
                                </span>
                            </div>

                            <div class="prose prose-lg max-w-none animate-[fadeSlideUp_0.6s_ease-out]">
                                <h3 class="text-xl font-semibold text-gray-800">Description</h3>
                                <p class="text-gray-600 leading-relaxed">{{ $cloth->description }}</p>
                            </div>

                            <!-- Sizes and Colors -->
                            <div class="grid grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <h3 class="text-2xl font-semibold gradient-dark bg-clip-text text-transparent">Sizes
                                    </h3>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach (explode(',', $cloth->size) as $size)
                                            <span class="size-chip font-medium">
                                                {{ trim($size) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <h3 class="text-2xl font-semibold gradient-dark bg-clip-text text-transparent">Colors
                                    </h3>
                                    <div class="flex flex-wrap gap-3">
                                        @if (is_array($cloth->color))
                                            @foreach ($cloth->color as $color)
                                                <span class="color-chip font-medium">
                                                    {{ $color }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="color-chip font-medium">
                                                {{ $cloth->color }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div id="purchaseSection" class="space-y-8" style="display: none;">
                                <!-- This will be shown for authenticated users -->
                                <div class="space-y-8">
                                    <div class="flex items-center gap-6">
                                        <label
                                            class="text-2xl font-semibold gradient-dark bg-clip-text text-transparent">Quantity</label>
                                        <div class="quantity-control flex items-center rounded-xl p-2 shadow-xl">
                                            <button type="button" onclick="decrementQuantity()"
                                                class="p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <input type="number" id="quantity"
                                                class="w-24 bg-transparent text-center text-xl font-medium" value="1"
                                                min="1" max="{{ $cloth->stock }}">
                                            <button type="button" onclick="incrementQuantity()"
                                                class="p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                        <span class="text-lg text-gray-500">Available: {{ $cloth->stock }}</span>
                                    </div>

                                    <div class="space-y-3">
                                        <h3 class="text-2xl font-semibold gradient-dark bg-clip-text text-transparent">Total
                                            Price</h3>
                                        <div class="price-tag inline-block" id="totalPrice">
                                            <span class="text-4xl font-bold">
                                                Rp {{ number_format($cloth->price, 2) }}
                                            </span>
                                        </div>
                                    </div>

                                    <button type="button" id="addToCartBtn"
                                        class="add-to-cart-btn w-full py-4 rounded-xl gradient-primary text-white
                                           font-semibold text-xl flex items-center justify-center gap-4
                                           hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                                        <span>Add to Cart</span>
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            <div id="loadingSpinner" class="hidden ml-2">
                                                <!-- Add spinner SVG here -->
                                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>

                            <div id="loginPrompt" class="mt-6" style="display: none;">
                                <!-- This will be shown for guests -->
                                <a href="{{ route('login') }}"
                                    class="block text-center gradient-secondary text-white py-4 px-6 rounded-xl
                                      hover:scale-[1.02] transition-all duration-300">
                                    Login to Purchase
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products Section -->
            <div class="mt-24 space-y-10">
                <h2 class="text-4xl font-bold gradient-primary bg-clip-text text-transparent">
                    Curated for You
                </h2>
                <x-clothes.cloth-grid :clothes="$clothes" :base-route="$baseRoute" />
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const token = localStorage.getItem('token');
                const purchaseSection = document.getElementById('purchaseSection');
                const loginPrompt = document.getElementById('loginPrompt');

                if (token) {
                    // Show purchase section for authenticated users
                    purchaseSection.style.display = 'block';
                    loginPrompt.style.display = 'none';
                } else {
                    // Show login prompt for guests
                    purchaseSection.style.display = 'none';
                    loginPrompt.style.display = 'block';
                }
            });

            const cartHandler = {
                price: {{ $cloth->price }},
                maxStock: {{ $cloth->stock }},
                isSubmitting: false,

                init() {
                    this.quantityInput = document.getElementById('quantity');
                    this.priceElement = document.getElementById('totalPrice');
                    this.addToCartBtn = document.getElementById('addToCartBtn');
                    this.spinner = document.getElementById('loadingSpinner');

                    if (!this.spinner) {
                        console.error('Loading spinner element not found');
                        return;
                    }

                    // Add event listeners
                    this.quantityInput.addEventListener('change', () => this.validateQuantity());
                    this.quantityInput.addEventListener('keyup', () => this.validateQuantity());
                    this.addToCartBtn.addEventListener('click', () => this.addToCart());

                    // Initialize total
                    this.updateTotal();
                },

                formatCurrency(amount) {
                    return 'Rp ' + amount.toLocaleString('id-ID', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },

                updateTotal() {
                    const quantity = parseInt(this.quantityInput.value) || 1;
                    const total = quantity * this.price;
                    this.priceElement.textContent = this.formatCurrency(total);
                },

                validateQuantity() {
                    let value = parseInt(this.quantityInput.value) || 1;
                    if (value < 1) value = 1;
                    if (value > this.maxStock) value = this.maxStock;
                    this.quantityInput.value = value;
                    this.updateTotal();
                },

                incrementQuantity() {
                    const currentValue = parseInt(this.quantityInput.value) || 0;
                    if (currentValue < this.maxStock) {
                        this.quantityInput.value = currentValue + 1;
                        this.updateTotal();
                    }
                },

                decrementQuantity() {
                    const currentValue = parseInt(this.quantityInput.value) || 2;
                    if (currentValue > 1) {
                        this.quantityInput.value = currentValue - 1;
                        this.updateTotal();
                    }
                },

                addToCart() {
                    if (this.isSubmitting || !this.spinner) return;

                    const token = localStorage.getItem('token');
                    if (!token) {
                        window.location.href = '/login';
                        return;
                    }

                    this.isSubmitting = true;
                    this.addToCartBtn.disabled = true;
                    this.spinner.classList.remove('hidden');

                    const quantity = parseInt(this.quantityInput.value) || 1;

                    fetch('{{ route('cart.add', $cloth->id) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Authorization': 'Bearer ' + token
                            },
                            body: `quantity=${quantity}`
                        })
                        .then(response => {
                            if (!response.ok) {
                                if (response.status === 401) {
                                    // Handle unauthorized (invalid/expired token)
                                    localStorage.removeItem('token');
                                    window.location.href = '/login';
                                    throw new Error('Please login again');
                                }
                                throw new Error('Failed to add to cart');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            } else {
                                throw new Error(data.message || 'Failed to add to cart');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: error.message || 'Something went wrong!',
                            });
                        })
                        .finally(() => {
                            this.isSubmitting = false;
                            this.addToCartBtn.disabled = false;
                            this.spinner.classList.add('hidden');
                        });
                }
            };

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', () => cartHandler.init());

            // Make functions globally available
            window.incrementQuantity = () => cartHandler.incrementQuantity();
            window.decrementQuantity = () => cartHandler.decrementQuantity();
            window.validateQuantity = () => cartHandler.validateQuantity();
        </script>
    @endpush
@endsection
