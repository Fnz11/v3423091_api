<div class="grid grid-cols-4 gap-4">
    @foreach ($clothes as $cloth)
        <a href="{{ route($baseRoute, $cloth->id) }}"
            class="col-span-1 bg-white shadow-xl shadow-slate-300 rounded-xl overflow-hidden hover:scale-[1.03] hover:rotate-3 transition-all duration-300 ease-out relative group">
            <div
                class="size-full absolute top-0 left-0 bg-white/0 group-hover:bg-white/30 transition-all duration-300 z-[5] pointer-events-none">
            </div>
            <img src="{{ asset('storage/images/clothes/' . $cloth->image) }}" alt="{{ $cloth->name }}"
                class="w-full h-48 aspect-square object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold">{{ $cloth->name }}</h3>
                <p class="text-gray-600">{{ formatRupiah($cloth->price) }}</p>
                <span class="text-blue-500 hover:underline">View Details</span>
            </div>
        </a>
    @endforeach
</div>
