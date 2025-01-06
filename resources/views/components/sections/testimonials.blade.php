<section class="relative py-32 overflow-hidden bg-gradient-to-b from-white via-gray-50 to-white perspective-3d">
    <!-- Premium Background Effects -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-[linear-gradient(45deg,rgba(138,43,226,0.02),rgba(219,39,119,0.02))]"></div>
        <div class="absolute inset-0 opacity-[0.02] bg-noise mix-blend-overlay"></div>
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-[120%] h-[500px] bg-gradient-conic from-purple-500/5 via-transparent to-rose-500/5 blur-3xl">
        </div>
    </div>

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <svg class="absolute top-0 left-0 w-[800px] h-[800px] -translate-x-1/2 -translate-y-1/2 text-purple-500/5 animate-float-slow"
            fill="currentColor">
            <circle cx="400" cy="400" r="400" />
        </svg>
        <svg class="absolute bottom-0 right-0 w-[600px] h-[600px] translate-x-1/3 translate-y-1/3 text-rose-500/5 animate-float-slow-reverse"
            fill="currentColor">
            <circle cx="300" cy="300" r="300" />
        </svg>
    </div>

    <div class="container relative mx-auto px-4 lg:px-8">
        <!-- Enhanced Header -->
        <div class="max-w-3xl mx-auto text-center mb-24 reveal-content">
            <span
                class="inline-flex items-center gap-3 text-sm tracking-[0.4em] uppercase bg-gradient-to-r from-purple-600 to-rose-500 bg-clip-text text-transparent reveal-text">
                <span class="h-[1px] w-8 bg-gradient-to-r from-purple-600/40 to-transparent"></span>
                Client Experiences
                <span class="h-[1px] w-8 bg-gradient-to-r from-transparent to-rose-500/40"></span>
            </span>
            <h2
                class="text-4xl md:text-5xl font-bold mt-6 mb-8 bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 bg-clip-text text-transparent reveal-text delay-200">
                Voices of Excellence
            </h2>
        </div>

        <!-- Premium Testimonials Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12 perspective-1000">
            @foreach ([['name' => 'Maria T.', 'role' => 'Fashion Enthusiast', 'content' => 'Absolutely stunning! The quality is unmatched and I felt like a queen wearing it.'], ['name' => 'John D.', 'role' => 'Art Director', 'content' => 'Elegant, stylish, and incredibly comfortable. Prestige Couture never disappoints.'], ['name' => 'Sarah L.', 'role' => 'Creative Designer', 'content' => 'A luxury brand that truly understands the art of fashion. Highly recommended.']] as $index => $testimonial)
                <div
                    class="group relative transform transition-all duration-300 hover:scale-[99%] delay-{{ $index * 200 }}">
                    <!-- Card Backdrop -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-white/80 to-white/40 backdrop-blur-xl rounded-2xl border border-white/20 shadow-2xl transform transition-transform duration-300 group-hover:scale-[99%]">
                    </div>

                    <!-- Quote Icon -->
                    <div class="absolute -top-6 left-8">
                        <div
                            class="relative w-12 h-12 rounded-full bg-gradient-to-r from-purple-600 to-rose-500 p-[1px] transform -rotate-6 group-hover:rotate-6 transition-transform duration-300">
                            <div class="absolute inset-[1px] bg-white rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-transparent bg-gradient-to-r from-purple-600 to-rose-500 bg-clip-text"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M9.5 7.5C9.5 8.5 9 9 8 9C7.5 9 7.25 8.5 7 8C6.75 7.5 6.75 7 7 6.5C7.25 6 7.5 5.5 8 5C8.5 4.5 9 4.25 9.5 4C10 3.75 10.5 3.75 11 4L10.5 6.5C10 7 9.5 7.25 9.5 7.5ZM15.5 7.5C15.5 8.5 15 9 14 9C13.5 9 13.25 8.5 13 8C12.75 7.5 12.75 7 13 6.5C13.25 6 13.5 5.5 14 5C14.5 4.5 15 4.25 15.5 4C16 3.75 16.5 3.75 17 4L16.5 6.5C16 7 15.5 7.25 15.5 7.5Z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="relative p-8 pt-12">
                        <div class="space-y-6">
                            <p class="text-lg text-gray-700 font-light leading-relaxed reveal-text">
                                "{{ $testimonial['content'] }}"
                            </p>
                            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                                <div
                                    class="w-12 h-12 rounded-full bg-gradient-to-r from-purple-600 to-rose-500 p-[1px]">
                                    <div class="w-full h-full rounded-full bg-white"></div>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $testimonial['name'] }}</h4>
                                    <p class="text-sm text-gray-500">{{ $testimonial['role'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
 
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .bg-noise {
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%' height='100%' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
    }

    .bg-gradient-conic {
        background-image: conic-gradient(var(--tw-gradient-stops));
    }

    .perspective-1000 {
        perspective: 1000px;
    }

    .perspective-3d {
        perspective: 2000px;
    }

    .reveal-text {
        opacity: 0;
        transform: translateY(20px);
        animation: revealText 1s cubic-bezier(0.2, 0, 0.2, 1) forwards;
    }

    @keyframes revealText {
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

    .animate-float-slow {
        animation: float 20s ease-in-out infinite;
    }

    .animate-float-slow-reverse {
        animation: float 25s ease-in-out infinite reverse;
    }

    .scroll-reveal {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .scroll-reveal.animated {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    @keyframes float {

        0%,
        100% {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        50% {
            transform: translate(-45%, -55%) rotate(15deg);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));
    });
</script>
