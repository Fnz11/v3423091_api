<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 reveal-content delay-600">
    @foreach ($clothes as $cloth)
        <a href="{{ route($baseRoute, $cloth->id) }}"
            class="group relative bg-white border rounded-2xl overflow-hidden card-hover card-3d">
            <!-- Premium Card Effects -->
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-rose-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
            </div>
            <div class="absolute inset-0 shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-700">
            </div>

            <!-- Enhanced Image Container -->
            <div class="relative aspect-[4/5] overflow-hidden">
                <img src="{{ asset('storage/images/clothes/' . $cloth->image) }}" alt="{{ $cloth->name }}"
                    class="absolute inset-0 w-full h-full object-cover transform transition-all duration-700
                        group-hover:scale-110 group-hover:rotate-1">

                <!-- Premium Overlay -->
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent 
                        opacity-0 group-hover:opacity-100 transition-all duration-500">
                </div>

                <!-- Enhanced Quick Actions -->
                <div
                    class="absolute inset-0 flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-y-4 group-hover:translate-y-0">
                    <button
                        class="p-4 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300 group/btn">
                        <span
                            class="absolute -top-10 left-1/2 -translate-x-1/2 bg-white px-3 py-1 rounded-lg text-sm font-medium opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300">
                            Wishlist
                        </span>
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    <button
                        class="p-4 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300 group/btn">
                        <span
                            class="absolute -top-10 left-1/2 -translate-x-1/2 bg-white px-3 py-1 rounded-lg text-sm font-medium opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300">
                            Quick View
                        </span>
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Enhanced Content -->
            <div class="p-8">
                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-gray-900">{{ $cloth->name }}</h3>
                    <p class="text-gray-500 line-clamp-2 font-light">{{ $cloth->description }}</p>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span
                            class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-rose-500 bg-clip-text text-transparent">
                            Rp. {{ number_format($cloth->price, 2) }}
                        </span>
                        <div
                            class="group/link inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors duration-300">
                            <span class="text-sm font-medium">Explore</span>
                            <svg class="w-5 h-5 transform group-hover/link:translate-x-1 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>
