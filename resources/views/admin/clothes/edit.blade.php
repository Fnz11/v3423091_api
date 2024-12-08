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
        <form action="{{ route('admin.clothes.update', $cloth->id) }}" method="POST" enctype="multipart/form-data"
            class="flex flex-col gap-4">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-2">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="input-primary" placeholder="Enter name here"
                    value="{{ old('name', $cloth->name) }}" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="stock">Clothes Stock</label>
                <input type="number" id="stock" name="stock" class="input-primary" placeholder="Enter stock here"
                    value="{{ old('stock', $cloth->stock) }}" required>
                @error('stock')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="price">Price (in IDR)</label>
                <input type="number" id="price" name="price" class="input-primary" placeholder="Enter price here"
                    value="{{ old('price', $cloth->price) }}" required>
                @error('price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="input-primary" rows="4" placeholder="Enter description here">{{ old('description', $cloth->description) }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="limited_edition">Limited Edition</label>
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
                @error('limited_edition')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="size">Size</label>
                <select id="size" name="size" class="input-primary" required>
                    <option value="" disabled>Select size</option>
                    <option value="XS" {{ old('size', $cloth->size) == 'XS' ? 'selected' : '' }}>XS</option>
                    <option value="S" {{ old('size', $cloth->size) == 'S' ? 'selected' : '' }}>S</option>
                    <option value="M" {{ old('size', $cloth->size) == 'M' ? 'selected' : '' }}>M</option>
                    <option value="L" {{ old('size', $cloth->size) == 'L' ? 'selected' : '' }}>L</option>
                    <option value="XL" {{ old('size', $cloth->size) == 'XL' ? 'selected' : '' }}>XL</option>
                    <option value="XXL" {{ old('size', $cloth->size) == 'XXL' ? 'selected' : '' }}>XXL</option>
                </select>
                @error('size')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="color">Color</label>
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
                @error('color')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="category">Category</label>
                <div class="flex flex-wrap gap-4">
                    @foreach ($categories as $category)
                        <label class="flex items-center">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="input-primary"
                                {{ in_array($category->id, $cloth->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                            <span class="ml-2">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('categories')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>


            <div class="flex flex-col gap-2">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" class="input-primary" onchange="previewImage(event)">
                <img id="image-preview" src="{{ asset('storage/images/clothes/' . $cloth->image) }}" alt="Image Preview"
                    class="w-32 h-32 object-cover mt-2 rounded-3xl">
                @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.clothes.index') }}" class="btn-secondary !h-12">Cancel</a>
                <button type="submit" class="btn-primary !h-12">Update Clothes</button>
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
