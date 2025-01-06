@props(['href'])

@php
    $isActive = Route::is($href);
@endphp

<a href="{{ $href }}"
    class="group block px-4 py-3 rounded-xl {{ $isActive ? 'bg-gradient-to-r from-purple-500/10 to-red-400/10 shadow-sm' : 'hover:bg-gray-50' }}">
    <div class="flex items-center gap-3">
        <div
            class="{{ $isActive
                ? 'bg-gradient-to-br from-purple-500 to-red-400 text-white shadow-lg shadow-purple-500/20'
                : 'bg-white text-gray-400 border border-gray-100 group-hover:border-purple-200 group-hover:text-purple-500' }} 
            p-2.5 rounded-lg">
            {{ $icon }}
        </div>
        <span
            class="{{ $isActive
                ? 'bg-gradient-to-r from-purple-500 to-red-400 bg-clip-text text-transparent font-semibold'
                : 'text-gray-600 group-hover:text-gray-900' }}">
            {{ $slot }}
        </span>
        @if ($isActive)
            <div class="ml-auto flex items-center gap-1">
                <div class="w-1 h-1 rounded-full bg-purple-500"></div>
                <div class="w-1 h-1 rounded-full bg-red-400"></div>
            </div>
        @endif
    </div>
</a>
