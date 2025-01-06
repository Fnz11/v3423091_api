@props(['clothes', 'baseRoute'])

<section id="collections"
    class="relative py-32 overflow-hidden bg-gradient-to-b from-gray-50 via-white to-gray-50 perspective-1000">
    <!-- Premium Background Effects -->
    <div class="absolute inset-0">
        <!-- Gradient Background -->
        <div class="absolute inset-0 bg-[linear-gradient(45deg,rgba(138,43,226,0.03),rgba(219,39,119,0.03))]"></div>

        <!-- Animated Patterns -->
        <div class="absolute inset-0 opacity-[0.02]"
            style="background-image: radial-gradient(circle at 2px 2px, gray 1px, transparent 0); background-size: 32px 32px;">
        </div>

        <!-- Dynamic Light Effects -->
        <div class="absolute inset-0">
            <div
                class="absolute top-1/4 left-0 w-[40rem] h-[40rem] bg-purple-500/[0.02] rounded-full filter blur-[100px] transform -translate-x-1/2 animate-float">
            </div>
            <div
                class="absolute bottom-1/4 right-0 w-[40rem] h-[40rem] bg-rose-500/[0.02] rounded-full filter blur-[100px] transform translate-x-1/2 animate-float delay-1000">
            </div>
        </div>

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-white/80 via-transparent to-white/80"></div>
    </div>

    <div class="container mx-auto px-4 lg:px-8">
        <div class="relative max-w-7xl mx-auto">
            <!-- Enhanced Header -->
            <div class="text-center mb-20 reveal-content">
                <div class="inline-block">
                    <span
                        class="inline-flex items-center gap-3 text-sm tracking-[0.5em] uppercase text-gray-500 reveal-text">
                        <span class="h-[1px] w-8 bg-gray-300"></span>
                        Premium Selection
                        <span class="h-[1px] w-8 bg-gray-300"></span>
                    </span>
                </div>
                <h2 class="text-5xl md:text-6xl font-bold text-gray-900 mt-6 mb-8 reveal-text delay-200 leading-tight">
                    Exclusive Collections
                </h2>
                <p class="max-w-2xl mx-auto text-gray-500 text-lg reveal-text delay-400 font-light">
                    Discover our carefully curated pieces that blend timeless elegance with contemporary design
                </p>
            </div>

            <!-- Premium Filters -->
            <div class="flex justify-center mb-16 reveal-content delay-500">
                <div
                    class="inline-flex gap-3 p-1.5 bg-white/80 backdrop-blur-xl rounded-full shadow-lg border border-gray-100">
                    @foreach (['All', 'New Arrivals', 'Trending', 'Best Sellers'] as $filter)
                        <button
                            class="relative px-8 py-3 rounded-full text-sm font-medium transition-all duration-500
                            {{ $filter === 'All' ? 'text-white' : 'text-gray-600 hover:text-gray-900' }}">
                            {{ $filter }}
                            @if ($filter === 'All')
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-purple-600 to-rose-500 rounded-full -z-10">
                                </div>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Enhanced Grid -->
            <x-clothes.cloth-grid :clothes="$clothes" :base-route="$baseRoute" />

        </div>
    </div>
</section>

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

    .delay-200 {
        animation-delay: 200ms;
    }

    .delay-400 {
        animation-delay: 400ms;
    }

    .delay-500 {
        animation-delay: 500ms;
    }

    .delay-600 {
        animation-delay: 600ms;
    }

    .card-hover {
        transform: translateY(0) scale(1);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0) translateX(0);
        }

        50% {
            transform: translateY(-10%) translateX(5%);
        }
    }

    .animate-float {
        animation: float 20s ease-in-out infinite;
    }

    .card-3d {
        transform-style: preserve-3d;
        transform: perspective(1000px) rotateX(0) rotateY(0);
        transition: transform 0.3s ease;
    }

    .card-3d:hover {
        transform: perspective(1000px) rotateX(var(--rotate-x)) rotateY(var(--rotate-y));
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
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

        // Add scroll observer
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
    });
</script>
