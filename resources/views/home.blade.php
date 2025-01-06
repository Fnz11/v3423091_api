@extends('layouts.app')

@section('content')
    <x-sections.hero 
        image="/images/Cover1.jpg"
        title="Elevate Your Style"
        subtitle="Experience the pinnacle of fashion where artistry meets elegance, crafted for those who appreciate exceptional quality">
        <div class="flex flex-col sm:flex-row gap-8 justify-center items-center">
            <a href="#collections" 
               class="group relative px-5 py-4 rounded-full min-w-[220px] overflow-hidden transition-all duration-500 bg-gradient-to-r from-purple-600/20 to-rose-600/20 hover:from-purple-600 hover:to-rose-600">
                <span class="relative z-10 font-medium text-white">
                    View Collections
                </span>
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-xl bg-gradient-to-r from-purple-600 to-rose-600"></div>
                <div class="absolute -inset-1 opacity-0 group-hover:opacity-30 transition-opacity duration-500 bg-gradient-to-r from-purple-600 to-rose-600 blur-xl"></div>
            </a>
            <a href="#about" 
               class="group relative px-5 py-4 rounded-full min-w-[220px] overflow-hidden transition-all duration-500">
                <span class="relative z-10 font-medium text-white group-hover:text-transparent bg-clip-text bg-gradient-to-r group-hover:from-purple-400 group-hover:to-rose-400">
                    Learn More
                </span>
                <div class="absolute inset-0 border border-white/50 rounded-full group-hover:border-transparent group-hover:bg-gradient-to-r group-hover:from-purple-600/20 group-hover:to-rose-600/20 transition-all duration-500"></div>
                <div class="absolute inset-px rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-500 bg-gradient-to-r from-purple-600/10 to-rose-600/10"></div>
            </a>
        </div>
    </x-sections.hero>

    <x-sections.collections :clothes="$clothes" :base-route="$baseRoute" />
    <x-sections.craftsmanship />
    <x-sections.testimonials />
@endsection
