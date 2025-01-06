<section
    class="relative min-h-screen py-32 overflow-hidden bg-gradient-to-b from-white via-gray-50 to-white perspective-3d">
    <!-- Ultra Premium Background Effects -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-[linear-gradient(45deg,rgba(255,255,255,0.9),transparent)] mix-blend-overlay">
        </div>
        <div class="absolute inset-0 bg-noise opacity-[0.02] mix-blend-overlay"></div>
        <div class="absolute inset-0"
            style="background: radial-gradient(circle at 50% 50%, rgba(138,43,226,0.03) 0%, transparent 50%)"></div>
        <div
            class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.9),transparent_20%,transparent_80%,rgba(255,255,255,0.9))]">
        </div>
    </div>

    <!-- Animated Particles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="particle-container" aria-hidden="true"></div>
    </div>

    <div class="container relative mx-auto px-4 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-20 lg:gap-32 max-w-8xl mx-auto">
            <!-- Enhanced Content Section -->
            <div class="lg:w-1/2 reveal-content perspective-1000 space-y-12">
                <!-- Premium Section Header -->
                <div class="space-y-8">
                    <div class="overflow-hidden inline-flex items-center gap-4">
                        <span class="h-[1px] w-12 bg-gradient-to-r from-purple-600 to-transparent"></span>
                        <span
                            class="text-sm tracking-[0.4em] uppercase bg-gradient-to-r from-purple-600 to-rose-500 bg-clip-text text-transparent font-medium reveal-text">
                            Artisanal Excellence
                        </span>
                    </div>

                    <div class="overflow-hidden">
                        <h2 class="text-5xl lg:text-7xl font-bold reveal-text delay-200 leading-tight">
                            <span
                                class="block bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 bg-clip-text text-transparent">
                                The Art of
                            </span>
                            <span
                                class="block bg-gradient-to-r from-purple-600 via-rose-500 to-purple-600 bg-clip-text text-transparent mt-2">
                                Craftsmanship
                            </span>
                        </h2>
                    </div>

                    <!-- Premium Content -->
                    <div class="prose prose-lg text-gray-600 reveal-text delay-400 space-y-6">
                        <p class="leading-relaxed">
                            At Prestige Couture, we pride ourselves on the impeccable quality of our garments. Each
                            piece is meticulously crafted by skilled artisans, using only the finest materials.
                        </p>
                        <ul class="space-y-4 text-gray-700">
                            <li class="flex items-center gap-3 reveal-item delay-500">
                                <span
                                    class="flex-shrink-0 w-2 h-2 rounded-full bg-gradient-to-r from-purple-600 to-rose-500"></span>
                                <span>Hand-selected premium materials</span>
                            </li>
                            <li class="flex items-center gap-3 reveal-item delay-600">
                                <span
                                    class="flex-shrink-0 w-2 h-2 rounded-full bg-gradient-to-r from-purple-600 to-rose-500"></span>
                                <span>Meticulous attention to detail</span>
                            </li>
                            <li class="flex items-center gap-3 reveal-item delay-700">
                                <span
                                    class="flex-shrink-0 w-2 h-2 rounded-full bg-gradient-to-r from-purple-600 to-rose-500"></span>
                                <span>Traditional craftsmanship meets modern design</span>
                            </li>
                        </ul>
                    </div>

                    <!-- New Feature Highlights -->
                    <div class="grid grid-cols-2 gap-8 mt-12">
                        @foreach (['Precision', 'Excellence', 'Innovation', 'Heritage'] as $feature)
                            <div class="group relative">
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-purple-500/5 to-rose-500/5 rounded-xl -z-10 transform transition-transform duration-500 group-hover:scale-105">
                                </div>
                                <div class="p-6 backdrop-blur-sm border border-gray-100/20 rounded-xl">
                                    <h4
                                        class="text-xl font-semibold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-2">
                                        {{ $feature }}</h4>
                                    <p class="text-gray-600 text-sm">Crafted with unparalleled attention to every
                                        detail.</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Enhanced Image Section -->
            <div class="lg:w-1/2 perspective-1000">
                <div class="relative group transform transition-all duration-700 hover:rotate-y-12">
                    <!-- Premium Glass Effect -->
                    <div
                        class="absolute inset-0 bg-gradient-to-tr from-white/10 to-white/5 backdrop-blur-sm rounded-2xl transform group-hover:scale-105 transition-transform duration-700 border border-white/20 shadow-2xl">
                    </div>

                    <!-- Main Image with Enhanced Effects -->
                    <div class="relative rounded-2xl overflow-hidden transform transition-all duration-700">
                        <img src="{{ asset('images/Cover2.jpg') }}" alt="Craftsmanship"
                            class="w-full h-[750px] object-cover transition-all duration-1000 filter brightness-110 group-hover:scale-110"
                            style="will-change: transform;">

                        <!-- Premium Overlays -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-black/20"></div>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-purple-900/20 via-transparent to-rose-900/20 mix-blend-overlay">
                        </div>

                        <!-- Interactive Floating Elements -->
                        <div
                            class="absolute inset-x-8 bottom-8 p-8 backdrop-blur-md bg-black/5 rounded-xl border border-white/10 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-700">
                            <div class="relative z-10">
                                <p class="text-white/90 font-light italic text-lg">
                                    "Perfection is not just about control; it's about letting excellence flow through
                                    every detail."
                                </p>
                                <div class="mt-4 flex items-center gap-3">
                                    <span class="h-[1px] w-12 bg-white/30"></span>
                                    <span class="text-white/70 text-sm tracking-wider">MASTER ARTISAN</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .reveal-item {
        opacity: 0;
        transform: translateX(-20px);
        animation: revealItem 0.8s cubic-bezier(0.2, 0, 0.2, 1) forwards;
    }

    @keyframes revealItem {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .delay-500 {
        animation-delay: 500ms;
    }

    .delay-600 {
        animation-delay: 600ms;
    }

    .delay-700 {
        animation-delay: 700ms;
    }

    .perspective-1000 {
        perspective: 1000px;
    }

    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin-slow {
        animation: spin-slow 15s linear infinite;
    }

    .rotate-y-12 {
        transform: rotateY(12deg);
    }

    .perspective-3d {
        perspective: 2000px;
    }

    .bg-noise {
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%' height='100%' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
    }

    .scroll-parallax {
        transform: translateY(var(--parallax-y, 0));
        transition: transform 0.1s ease-out;
    }

    .scroll-rotate-3d {
        transform: perspective(1000px) rotateX(var(--rotate-x, 0deg));
        transition: transform 0.1s ease-out;
    }
</style>

<script>
    // Add this to your existing scripts
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.querySelector('.particle-container');
        for (let i = 0; i < 50; i++) {
            const particle = document.createElement('div');
            particle.className =
                'absolute w-1 h-1 bg-gradient-to-r from-purple-500/20 to-rose-500/20 rounded-full';
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;
            particle.style.animation = `float ${5 + Math.random() * 10}s linear infinite`;
            container.appendChild(particle);
        }
    });

    const observerOptions = {
        root: null,
        threshold: 0.1,
        rootMargin: "0px"
    };

    const scrollElements = document.querySelectorAll('.scroll-parallax');
    const rotate3dElements = document.querySelectorAll('.scroll-rotate-3d');

    window.addEventListener('scroll', () => {
        const scrolled = window.scrollY;
        
        scrollElements.forEach(el => {
            const speed = el.dataset.speed || 0.2;
            const yPos = -(scrolled * speed);
            el.style.setProperty('--parallax-y', `${yPos}px`);
        });

        rotate3dElements.forEach(el => {
            const rect = el.getBoundingClientRect();
            const centerY = (rect.top + rect.bottom) / 2;
            const viewportCenter = window.innerHeight / 2;
            const rotation = (centerY - viewportCenter) * 0.02;
            el.style.setProperty('--rotate-x', `${rotation}deg`);
        });
    });

    // Add scroll-triggered animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal-content, .reveal-text').forEach(el => observer.observe(el));
</script>
