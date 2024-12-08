@extends('layouts.admin') <!-- Extends the admin layout with sidebar -->

@section('title', $cloth->name)
@section('page-title', 'Clothes Management')

@section('content')
    <div class="bg-white shadow-2xl shadow-slate-200 h-full rounded-2xl overflow-hidden p-6 flex flex-col">
        <h1 class="text-2xl font-semibold">Product Details</h1>
        <x-clothes.cloth-detail :cloth="$cloth" />
    </div>

    <h1 class="text-2xl font-semibold mt-10">Other Products</h1>
    <x-clothes.cloth-grid :clothes="$clothes" :base-route="$baseRoute" />
@endsection
