@props(['href'])

@php
    $isActive = Route::is($href);
@endphp

<li class="mb-2">
    <a href="{{ route($href) }}"
        class="{{ $isActive ? 'font-bold bg-white shadow-2xl shadow-slate-300' : 'font-medium hover:bg-white hover:shadow-2xl hover:scale-[1.03] shadow-slate-300' }} flex items-center gap-2 text-gray-700 hover:text-gray-900 p-2 rounded-xl transition-all duration-500 ease-out">
        <span
            class="{{ $isActive ? '!bg-gradient-to-br gradient-primary text-white' : 'bg-white shadow-xl' }}  p-[0.75rem] aspect-square rounded-xl">
            {{ $icon ?? '' }}
        </span>
        {{ $slot }}
    </a>
</li>
