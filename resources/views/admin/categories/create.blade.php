@extends('layouts.admin')

@section('title', 'Add New Category')
@section('page-title', 'Category Management')

@section('content')
    <div class="bg-white shadow-2xl shadow-slate-200 h-full rounded-2xl overflow-hidden p-6 flex flex-col gap-3">
        <div class="flex justify-between">
            <div class="flex flex-col">
                <h1 class="font-semibold text-lg">Add New Category</h1>
                <p class="text-slate-500 text-base">Fill the form below to add a new category to the store.</p>
            </div>
        </div>

        <!-- Form for creating new category -->
        <form action="{{ route('admin.categories.store') }}" method="POST" class="flex flex-col gap-4">
            @csrf

            <!-- Category Name -->
            <div class="flex flex-col gap-2">
                <label for="name">Category Name</label>
                <input type="text" name="name" id="name" class="input-primary" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary !h-12">Cancel</a>
                <button type="submit" class="btn-primary !h-12">Add Category</button>
            </div>
        </form>
    </div>
@endsection
