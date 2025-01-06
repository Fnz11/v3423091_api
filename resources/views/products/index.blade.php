@extends('layouts.admin')

@section('title', 'Find Products')
@section('page-title', 'Browse Products')

@push('styles')
    <style>
        .perspective-1000 {
            perspective: 1000px;
        }

        .reveal-content {
            opacity: 0;
            transform: translateY(30px);
            animation: revealContent 1s cubic-bezier(0.2, 0, 0.2, 1) forwards;
        }

        @keyframes revealContent {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-hover {
            transform: translateY(0) scale(1);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .card-3d {
            transform-style: preserve-3d;
            transform: perspective(1000px) rotateX(0) rotateY(0);
            transition: transform 0.3s ease;
        }

        .scroll-fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .scroll-fade-up.animated {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
@endpush

@section('content')
<div class="w-full mx-auto">
    <h1 class="text-4xl font-bold mb-8 text-gray-800 tracking-tight">Browse Products</h1>

    <div class="cart-container">
        <!-- Search and filters section -->
        <div class="!bg-white backdrop-blur-sm rounded-xl p-4 mb-6 shadow-[0_8px_32px_0_rgba(31,38,135,0.15)]">
            <!-- Enhanced Search Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div class="reveal-content" style="animation-delay: 200ms">
                    <h2 class="text-2xl font-bold text-gray-800">Discover Products</h2>
                    <p class="text-gray-500 mt-1"><span id="total-products">{{ $totalProducts }}</span> items available</p>
                </div>

                <div class="flex items-center gap-4 reveal-content" style="animation-delay: 400ms">
                    <div class="relative">
                        <input type="search" id="search-input" value="{{ request('search', '') }}"
                            placeholder="Search products..."
                            class="w-full md:w-72 pl-10 pr-4 py-2.5 bg-white/50 backdrop-blur-xl border border-gray-200 rounded-xl focus:ring-purple-500 focus:border-purple-500 transition-all">
                        <x-zondicon-search class="w-5 h-5 text-gray-400 absolute left-3 top-3" />
                    </div>
                </div>
            </div>

            <!-- Enhanced Filters -->
            <div class="flex flex-wrap items-center gap-4 mb-8 reveal-content" style="animation-delay: 600ms">
                <div class="flex gap-2 p-1.5 bg-white/50 backdrop-blur-xl rounded-full shadow-sm border border-gray-100">
                    @foreach (['all' => 'All Products', 'new_arrivals' => 'New Arrivals', 'popular' => 'Popular', 'featured' => 'Featured'] as $value => $label)
                        <button data-filter="{{ $value }}"
                            class="filter-btn px-6 py-2 rounded-full text-sm font-medium transition-all 
                        {{ request('filter', 'all') === $value ? 'bg-gradient-to-r from-purple-600 to-rose-500 text-white' : 'text-gray-600 hover:bg-white hover:text-gray-900' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <div class="h-8 w-px bg-gray-200"></div>

                <div class="flex flex-wrap gap-2">
                    <button data-category="all"
                        class="category-btn px-4 py-2 rounded-xl text-sm font-medium border border-gray-200 
                    {{ !request('category') || request('category') == 'all' ? 'border-purple-500 text-purple-600 bg-purple-50' : 'hover:border-purple-200 hover:text-purple-600' }}
                    transition-all">
                        All Categories
                    </button>
                    @foreach ($categories as $category)
                        <button data-category="{{ $category->id }}"
                            class="category-btn px-4 py-2 rounded-xl text-sm font-medium border border-gray-200 
                        {{ request('category') == $category->id ? 'border-purple-500 text-purple-600 bg-purple-50' : 'hover:border-purple-200 hover:text-purple-600' }}
                        transition-all">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Products Grid Section -->
        <div class="!bg-white backdrop-blur-sm rounded-xl p-4 shadow-[0_8px_32px_0_rgba(31,38,135,0.15)]">
            <div id="products-grid">
                @if ($clothes->isEmpty())
                    <div class="text-center py-16 reveal-content" style="animation-delay: 800ms">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                            <x-zondicon-search class="w-12 h-12 text-gray-400" />
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">No products found</h3>
                        <p class="text-gray-500 mb-6">We couldn't find any products matching your search criteria.</p>
                        <button onclick="resetFilters()"
                            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-rose-500 text-white rounded-xl hover:scale-105 transition-all shadow-lg shadow-purple-500/20">
                            Reset Filters
                        </button>
                    </div>
                @else
                    <x-clothes.cloth-grid :clothes="$clothes" base-route="landing.detail" />
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center" id="pagination">
                {!! $clothes->appends(request()->query())->links() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let currentFilter = '{{ request('filter', 'all') }}';
            let currentCategory = '{{ request('category', '') }}';
            let currentSearch = '{{ request('search', '') }}';
            const debounceTimeout = 300;
            let debounceTimer;

            function updateProducts(page = 1) {
                const url = new URL(window.location);
                url.searchParams.set('filter', currentFilter);
                if (currentCategory) url.searchParams.set('category', currentCategory);

                // Handle empty search differently
                if (currentSearch === '') {
                    url.searchParams.delete('search');
                } else {
                    url.searchParams.set('search', currentSearch);
                }

                if (page > 1) url.searchParams.set('page', page);

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('products-grid').innerHTML = data.html;
                        document.getElementById('total-products').textContent = data.totalProducts;
                        document.getElementById('pagination').innerHTML = data.pagination;
                        window.history.pushState({}, '', url);
                        initCardEffects();
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Filter buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    currentFilter = btn.dataset.filter;
                    document.querySelectorAll('.filter-btn').forEach(b =>
                        b.classList.remove('bg-gradient-to-r', 'from-purple-600', 'to-rose-500',
                            'text-white'));
                    btn.classList.add('bg-gradient-to-r', 'from-purple-600', 'to-rose-500',
                        'text-white');
                    updateProducts();
                });
            });

            // Category buttons
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    currentCategory = btn.dataset.category;
                    document.querySelectorAll('.category-btn').forEach(b =>
                        b.classList.remove('border-purple-500', 'text-purple-600',
                            'bg-purple-50'));
                    btn.classList.add('border-purple-500', 'text-purple-600', 'bg-purple-50');
                    updateProducts();
                });
            });

            // Search input with empty search handling
            const searchInput = document.getElementById('search-input');
            searchInput.addEventListener('input', (e) => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    currentSearch = e.target.value.trim();
                    updateProducts();
                }, debounceTimeout);
            });

            // Handle backspace/delete to empty search
            searchInput.addEventListener('keyup', (e) => {
                if (e.target.value === '') {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        currentSearch = '';
                        updateProducts();
                    }, debounceTimeout);
                }
            });

            // Initialize 3D card effects
            function initCardEffects() {
                // 3D Card Effect
                const cards = document.querySelectorAll('.card-3d');
                cards.forEach(card => {
                    card.addEventListener('mousemove', e => {
                        const rect = card.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        const centerX = rect.width / 2;
                        const centerY = rect.height / 2;
                        const rotateX = (y - centerY) / 20;
                        const rotateY = (centerX - x) / 20;

                        card.style.setProperty('--rotate-x', `${rotateX}deg`);
                        card.style.setProperty('--rotate-y', `${rotateY}deg`);
                    });

                    card.addEventListener('mouseleave', () => {
                        card.style.setProperty('--rotate-x', '0deg');
                        card.style.setProperty('--rotate-y', '0deg');
                    });
                });

                // Scroll Animation
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animated');
                        }
                    });
                }, {
                    threshold: 0.1
                });

                document.querySelectorAll('.scroll-fade-up').forEach(el => observer.observe(el));
            }

            function resetFilters() {
                currentFilter = 'all';
                currentCategory = 'all';
                currentSearch = '';

                // Reset search input
                document.getElementById('search-input').value = '';

                // Reset filter buttons
                document.querySelectorAll('.filter-btn').forEach(b => {
                    const isAll = b.dataset.filter === 'all';
                    b.classList.toggle('bg-gradient-to-r', isAll);
                    b.classList.toggle('from-purple-600', isAll);
                    b.classList.toggle('to-rose-500', isAll);
                    b.classList.toggle('text-white', isAll);
                });

                // Reset category buttons
                document.querySelectorAll('.category-btn').forEach(b => {
                    const isAll = b.dataset.category === 'all';
                    b.classList.toggle('border-purple-500', isAll);
                    b.classList.toggle('text-purple-600', isAll);
                    b.classList.toggle('bg-purple-50', isAll);
                });

                updateProducts();
            }

            // Make resetFilters available globally
            window.resetFilters = resetFilters;
        });
    </script>
@endpush
@endsection
