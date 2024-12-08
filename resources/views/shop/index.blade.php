@extends('layouts.app')

@section('content')
    <h1>Our Clothes</h1>
    <div class="clothes-grid">
        @foreach($clothes as $cloth)
            <div class="cloth-item">
                <img src="{{ asset('storage/' . $cloth->image) }}" alt="{{ $cloth->name }}">
                <h2>{{ $cloth->name }}</h2>
                <a href="{{ route('shop.show', $cloth->id) }}">View Details</a>
            </div>
        @endforeach
    </div>
@endsection
