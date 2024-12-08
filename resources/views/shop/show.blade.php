@extends('layouts.app')

@section('content')
    <h1>{{ $clothes->name }}</h1>
    <img src="{{ asset('storage/' . $clothes->image) }}" alt="{{ $clothes->name }}">
    <p>{{ $clothes->description }}</p>
    <p>Price: ${{ $clothes->price }}</p>
    <a href="https://wa.me/1234567890?text=I'm interested in {{ $clothes->name }}">Buy via WhatsApp</a>
@endsection
