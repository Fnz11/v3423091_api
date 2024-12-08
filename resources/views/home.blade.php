@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="bg-cover bg-center h-screen relative flex items-center justify-center">
        <img src="/images/Cover1.jpg" class="size-full object-cover absolute top-0 left-0" alt="">
        <div class="bg-black/30 size-full absolute top-0 left-0 z-[1]"></div>
        <div class="container mx-auto px-4 relative z-[10] text-center">
            <h2 class="text-6xl font-extrabold text-white mb-4 tracking-widest uppercase">Elevate Your Style</h2>
            <p class="text-2xl text-gray-200 mb-8">Discover the elegance and luxury of high-end fashion</p>
        </div>
    </section>

    <!-- Featured Collection Section -->
    <section class="py-24 bg-gray-50">
        <div class="container mx-auto md:px-52">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Exclusive Collections</h2>
            <x-clothes.cloth-grid :clothes="$clothes" :base-route="$baseRoute" />
        </div>
    </section>

    <!-- Our Craftsmanship Section -->
    <section class="bg-white py-5">
        <div class="container mx-auto px-32 flex flex-col lg:flex-row items-center justify-between space-y-8 lg:space-y-0">
            <div class="lg:w-1/2">
                <h2 class="text-5xl font-bold text-gray-800 mb-6">The Art of Craftsmanship</h2>
                <p class="text-lg text-gray-600 mb-6">At Prestige Couture, we pride ourselves on the impeccable quality of
                    our garments. Each piece is meticulously crafted by skilled artisans, using only the finest materials,
                    ensuring that every detail exudes elegance and luxury.</p>
            </div>
            <div class="lg:w-1/3">
                <img src="{{ asset('images/Cover2.jpg') }}" alt="Craftsmanship" class="rounded-lg shadow-lg">
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-24 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">What Our Clients Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <p class="text-lg text-gray-700 mb-4">"Absolutely stunning! The quality is unmatched and I felt like a
                        queen wearing it."</p>
                    <p class="text-gray-500">- Maria T.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <p class="text-lg text-gray-700 mb-4">"Elegant, stylish, and incredibly comfortable. Prestige Couture
                        never disappoints."</p>
                    <p class="text-gray-500">- John D.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <p class="text-lg text-gray-700 mb-4">"A luxury brand that truly understands the art of fashion. Highly
                        recommended."</p>
                    <p class="text-gray-500">- Sarah L.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="container mx-auto px-4 text-center">
            <p class="text-lg font-bold text-white">Prestige Couture</p>
            <p class="mt-4">&copy; 2024 Prestige Couture. All rights reserved.</p>
        </div>
    </footer>
@endsection
