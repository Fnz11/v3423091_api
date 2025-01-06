@extends('layouts.admin')

@section('title', 'Edit Clothes')
@section('page-title', 'Clothes Management')

@section('content')
    <div class="bg-white shadow-2xl shadow-slate-200 h-full rounded-2xl overflow-hidden p-6 flex flex-col gap-3">
        <div class="flex justify-between">
            <div class="flex flex-col">
                <h1 class="font-semibold text-lg">Edit Clothes</h1>
                <p class="text-slate-500 text-base">Update the details below to edit the clothes.</p>
            </div>
        </div>

        <!-- Form for editing existing clothes -->
        <form action="{{ route('admin.clothes.update', $cloth->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name Input -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <input type="text" name="name" id="name" required value="{{ old('name', $cloth->name) }}"
                           class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer">
                    <label for="name" class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                        Name
                    </label>
                </div>
            </div>

            <!-- Stock Input -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <input type="number" name="stock" id="stock" required value="{{ old('stock', $cloth->stock) }}"
                           class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer">
                    <label for="stock" class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                        Clothes Stock
                    </label>
                </div>
            </div>

            <!-- Price Input -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <input type="number" name="price" id="price" required value="{{ old('price', $cloth->price) }}"
                           class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer">
                    <label for="price" class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                        Price (in IDR)
                    </label>
                </div>
            </div>

            <!-- Description Input -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <textarea name="description" id="description" required rows="4"
                              class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer">{{ old('description', $cloth->description) }}</textarea>
                    <label for="description" class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                        Description
                    </label>
                </div>
            </div>

            <!-- Limited Edition Input -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <div class="flex items-center gap-4">
                        <label class="flex items-center">
                            <input type="radio" id="limited_edition_yes" name="limited_edition" value="1"
                                   class="input-primary"
                                   {{ old('limited_edition', $cloth->limited_edition) == '1' ? 'checked' : '' }} required>
                            <span class="ml-2">Yes</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" id="limited_edition_no" name="limited_edition" value="0"
                                   class="input-primary"
                                   {{ old('limited_edition', $cloth->limited_edition) == '0' ? 'checked' : '' }} required>
                            <span class="ml-2">No</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Size Input -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <select id="size" name="size" class="input-primary" required>
                        <option value="" disabled>Select size</option>
                        <option value="XS" {{ old('size', $cloth->size) == 'XS' ? 'selected' : '' }}>XS</option>
                        <option value="S" {{ old('size', $cloth->size) == 'S' ? 'selected' : '' }}>S</option>
                        <option value="M" {{ old('size', $cloth->size) == 'M' ? 'selected' : '' }}>M</option>
                        <option value="L" {{ old('size', $cloth->size) == 'L' ? 'selected' : '' }}>L</option>
                        <option value="XL" {{ old('size', $cloth->size) == 'XL' ? 'selected' : '' }}>XL</option>
                        <option value="XXL" {{ old('size', $cloth->size) == 'XXL' ? 'selected' : '' }}>XXL</option>
                    </select>
                </div>
            </div>

            <!-- Color Input -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <div class="flex flex-wrap gap-4">
                        @php
                            $colors = ['Red', 'Blue', 'Green', 'Yellow', 'Black', 'White'];
                            $selectedColors = explode(', ', old('color', $cloth->color));
                        @endphp
                        @foreach ($colors as $color)
                            <label class="flex items-center">
                                <input type="checkbox" name="color[]" value="{{ $color }}" class="input-primary"
                                       {{ in_array($color, $selectedColors) ? 'checked' : '' }}>
                                <span class="ml-2">{{ $color }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Category Input -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <div class="flex flex-wrap gap-4">
                        @foreach ($categories as $category)
                            <label class="flex items-center">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="input-primary"
                                       {{ in_array($category->id, $cloth->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <span class="ml-2">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Image Input -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <input type="file" id="image" name="image" class="input-primary" onchange="previewImage(event)">
                    <img id="image-preview" src="{{ asset('storage/images/clothes/' . $cloth->image) }}" alt="Image Preview"
                         class="w-32 h-32 object-cover mt-2 rounded-3xl">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 pt-6">
                <a href="{{ route('admin.clothes.index') }}" 
                   class="relative inline-flex items-center justify-center px-6 py-3 text-base font-medium text-slate-700 bg-white hover:bg-slate-50 rounded-xl shadow-sm transition-all duration-200 hover:translate-y-[-2px] hover:shadow-md group">
                    Cancel
                </a>
                <button type="submit" 
                        class="relative inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-gradient-to-r from-slate-800 to-slate-900 rounded-xl hover:from-slate-900 hover:to-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transform transition-all duration-200 hover:shadow-[0_0_20px_-3px_rgba(0,0,0,0.2)] hover:-translate-y-0.5">
                    Update Clothes
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('image-preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection

@push('scripts')
<script>
document.querySelector('form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    
    try {
        const formData = new FormData(this);
        formData.append('_method', 'PUT'); // For PUT requests
        const token = localStorage.getItem('token') || getCookie('token');
        
        const response = await fetch(this.action, {
            method: 'POST', // Use POST with _method for PUT
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            window.location.href = data.redirect;
        } else {
            alert(data.message || 'Failed to update clothes');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    } finally {
        submitBtn.disabled = false;
    }
});

// ...existing previewImage function...
</script>
@endpush
