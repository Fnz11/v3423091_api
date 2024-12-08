@props(['href'])

<li>
    <a href="{{ $href }}"
        class="text-white hover:scale-[1.05] transition-all duration-500 ease-out font-medium tracking-wider">
        {{ $slot }}
    </a>
</li>
