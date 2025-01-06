@props(['href'])

<li class="relative overflow-hidden group perspective-1000">
    <a href="{{ $href }}"
        class="inline-block text-gray-300 transition-all duration-500 ease-out
        transform hover:-translate-y-0.5 hover:scale-105 will-change-transform
        font-medium tracking-wide hover:text-transparent hover:bg-clip-text
        hover:bg-gradient-to-r hover:from-purple-200 hover:via-pink-200 hover:to-white">
        <span class="relative z-10 block">{{ $slot }}</span>
        <span class="absolute inset-0 bg-gradient-to-r from-purple-400/0 via-pink-400/10 to-purple-400/0
            scale-x-0 group-hover:scale-x-100 transition-transform duration-700 ease-out"></span>
    </a>
</li>
