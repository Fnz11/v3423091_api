@extends('layouts.app')

@section('title', 'Clothes Collection')

@section('content')
    <div class="bg-white p-6">
        <h1 class="text-2xl font-semibold mb-4">Clothes Collection</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($clothes as $cloth)
                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                    <a href="{{ route('clothes.show', $cloth->id) }}">
                        <img src="{{ asset('storage/images/clothes/' . $cloth->image) }}" alt="{{ $cloth->name }}"
                            class="w-full h-56 object-cover rounded-md">
                        <h2 class="mt-2 text-lg font-semibold">{{ $cloth->name }}</h2>
                        <p class="text-gray-700">IDR {{ number_format($cloth->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">Stock: {{ $cloth->stock }}</p>
                        <p class="text-sm text-gray-500">Size: {{ $cloth->size }}</p>
                        @if ($cloth->limited_edition)
                            <span class="text-red-500 text-sm font-bold">Limited Edition</span>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
