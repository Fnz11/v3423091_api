@props(['image', 'title', 'subtitle'])

<section class="relative h-[140vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 parallax-wrapper">
        <img src="{{ $image }}" class="absolute inset-0 w-full h-[120%] object-cover transform scale-105 motion-safe:animate-subtle-zoom" alt="Hero background">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/40 to-black/90">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_transparent_0%,_black_100%)] opacity-40"></div>
    </div>
    
    <div class="container relative z-10 px-4 md:px-8 text-center">
        <div class="reveal-content space-y-10">
            <div class="space-y-6">
                <div class="overflow-hidden">
                    <span class="block text-sm md:text-base text-white/90 tracking-[0.5em] uppercase reveal-text">
                        Luxury & Elegance
                    </span>
                </div>
                <div class="overflow-hidden">
                    <h2 class="text-5xl md:text-8xl font-bold text-white tracking-wider uppercase reveal-text delay-200 font-serif">
                        {{ $title }}
                    </h2>
                </div>
                <div class="overflow-hidden max-w-xl mx-auto">
                    <p class="text-lg md:text-xl text-white/80 font-light leading-relaxed reveal-text delay-400">
                        {{ $subtitle }}
                    </p>
                </div>
            </div>
            <div class="reveal-content delay-500">
                {{ $slot }}
            </div>
        </div>
    </div>

    <div class="absolute bottom-12 left-1/2 -translate-x-1/2 scroll-indicator">
        <div class="h-14 w-8 rounded-full border border-white/30 p-2 backdrop-blur-sm">
            <div class="w-1.5 h-3 bg-white/50 rounded-full mx-auto animate-scroll-dot"></div>
        </div>
    </div>
</section>

<style>
    .parallax-wrapper { will-change: transform; }
    
    @keyframes subtle-zoom {
        0% { transform: scale(1.05); }
        100% { transform: scale(1.15); }
    }
    
    .reveal-content > * {
        opacity: 0;
        transform: translateY(30px);
        animation: reveal 1s cubic-bezier(0.2, 0, 0.2, 1) forwards;
    }
    
    .reveal-text {
        opacity: 0;
        transform: translateY(100%);
        animation: text-reveal 1.2s cubic-bezier(0.2, 0, 0.2, 1) forwards;
    }
    
    @keyframes reveal {
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes text-reveal {
        to { opacity: 1; transform: translateY(0); }
    }
    
    .delay-200 { animation-delay: 200ms; }
    .delay-400 { animation-delay: 400ms; }
    .delay-500 { animation-delay: 500ms; }
    
    @keyframes scroll-dot {
        0%, 100% { transform: translateY(0); opacity: 0.5; }
        50% { transform: translateY(10px); opacity: 1; }
    }
    
    .animate-scroll-dot {
        animation: scroll-dot 2s ease-in-out infinite;
    }
    
    .motion-safe\:animate-subtle-zoom {
        animation: subtle-zoom 20s ease-out forwards;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.querySelector('.parallax-wrapper');
    let lastScrollY = 0;
    
    const parallaxEffect = () => {
        const scrolled = window.scrollY;
        const speed = 0.5;
        const delta = (scrolled - lastScrollY) * speed;
        const transform = `translateY(${scrolled * speed}px) scale(${1 + scrolled * 0.0005})`;
        
        wrapper.style.transform = transform;
        lastScrollY = scrolled;
        requestAnimationFrame(parallaxEffect);
    };
    
    requestAnimationFrame(parallaxEffect);
});
</script>
