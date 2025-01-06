@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page-title', 'Category Management')

@section('content')
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl shadow-[0_0_50px_-12px_rgb(0,0,0,0.12)] border border-white/40 p-8">
        <div class="flex justify-between">
            <div class="flex flex-col">
                <h1 class="font-semibold text-lg">Edit Category</h1>
                <p class="text-slate-500 text-base">Update the form below to edit the category details.</p>
            </div>
        </div>

        <!-- Form for updating category -->
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Category Name Input -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <input type="text" name="name" id="name" required value="{{ old('name', $category->name) }}"
                           class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer">
                    <label for="name" 
                           class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                        Category Name
                    </label>
                </div>
                @error('name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 pt-6">
                <a href="{{ route('admin.categories.index') }}" 
                   class="relative inline-flex items-center justify-center px-4 py-3 text-base font-medium text-slate-700 bg-white hover:bg-slate-50 rounded-xl shadow-sm transition-all duration-200 hover:translate-y-[-2px] hover:shadow-md group">
                    <span class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-xl blur opacity-0 group-hover:opacity-75 transition duration-1000"></span>
                    Cancel
                </a>
                <button type="submit" 
                        class="relative inline-flex items-center justify-center px-4 py-3 text-base font-medium text-white bg-gradient-to-r from-slate-800 to-slate-900 rounded-xl hover:from-slate-900 hover:to-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transform transition-all duration-200 hover:shadow-[0_0_20px_-3px_rgba(0,0,0,0.2)] hover:-translate-y-0.5">
                    Update Category
                </button>
            </div>
        </form>
    </div>
@endsection
