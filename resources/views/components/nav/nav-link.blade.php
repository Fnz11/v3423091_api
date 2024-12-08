@props(['href'])

<li class="hover:scale-[1.1] transition-all duration-300 ease-out">
    <a href="{{ $href }}"
        class="text-gray-700 font-semibold uppercase text-sm tracking-widest">
        {{ $slot }}
    </a>
</li>
