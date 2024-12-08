<div class="flex flex-col md:flex-row justify-between gap-20">
    <img src="{{ asset('storage/images/clothes/' . $cloth->image) }}" alt="{{ $cloth->name }}"
        class="w-full md:w-1/2 h-auto aspect-square object-cover rounded-3xl">

    <div class="flex flex-col gap-2 md:w-1/2">
        <h1 class="text-3xl font-semibold">{{ $cloth->name }}</h1>
        @if ($cloth->limited_edition)
            <span
                class="gradient-gold w-fit px-3 shadow-md py-1 uppercase tracking-widest rounded-full text-xs font-bold">Limited
                Edition</span>
        @endif
        <p class="text-gray-700 text-lg font-semibold">{{ formatRupiah($cloth->price) }}</p>
        <p class="text-gray-500">Stock: {{ $cloth->stock }}</p>
        <p class="text-gray-500">Size: {{ $cloth->size }}</p>
        <p class="text-gray-500">Color: {{ $cloth->color }}</p>
        <p class="text-gray-500">Category: {{ $cloth->category }}</p>
        <div class="mt-4 flex flex-col">
            <span class="font-semibold">Description: </span>
            <p>
                {{ $cloth->description }}
            </p>
            <a target="_blank"
                href="https://wa.me/+6283175022933?text=I'm%20interested%20in%20buying%20{{ urlencode($cloth->name) }}"
                class="btn-primary mt-5">
                Buy Now
            </a>
        </div>
    </div>
</div>
