@props(['href'])

<div class="relative group perspective-[1000px] overflow-hidden">
    <a href="{{ $href }}"
        class="relative block px-4 py-2.5 text-gray-800 font-medium text-sm tracking-wide uppercase
        will-change-transform will-change-opacity
        transition-all duration-500 ease-out
        hover:text-indigo-900 text-black
        after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px]
        after:origin-left after:scale-x-0 after:group-hover:scale-x-100
        after:bg-gradient-to-r after:from-indigo-500 after:via-purple-500 after:to-pink-500
        after:transition-transform after:duration-500 after:ease-out">
        <span class="relative inline-flex items-center group-hover:translate-y-[-2px] transition-transform duration-500">
            {{ $slot }}
            <svg class="w-4 h-4 ml-1 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-500" 
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </span>
    </a>
    
    <div class="absolute inset-0 -z-10 opacity-0 group-hover:opacity-100
        bg-gradient-to-r from-indigo-50/80 via-purple-50/80 to-pink-50/80
        dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20
        backdrop-blur-md rounded-lg scale-95 group-hover:scale-100
        rotate-x-12 group-hover:rotate-x-0
        translate-y-4 group-hover:translate-y-0
        transition-all duration-500 ease-out
        will-change-transform will-change-opacity"></div>
</div>
