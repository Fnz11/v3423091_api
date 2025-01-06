@extends('layouts.admin')

@section('title', 'Add New Clothes')
@section('page-title', 'Clothes Management')

@section('content')
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl shadow-[0_0_50px_-12px_rgb(0,0,0,0.12)] border border-white/40 p-8">
        <div class="flex justify-between">
            <div class="flex flex-col">
                <h1 class="font-semibold text-lg">Add New Clothes</h1>
                <p class="text-slate-500 text-base">Fill the form below to add new clothes to the store.</p>
            </div>
        </div>

        <!-- Form for creating new clothes -->
        <form action="{{ route('admin.clothes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                           class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer">
                    <label for="name" 
                           class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                        Name
                    </label>
                </div>
                @error('name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <input type="number" name="stock" id="stock" required value="{{ old('stock') }}"
                           class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer">
                    <label for="stock" class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                        Stock
                    </label>
                </div>
                @error('stock')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <input type="number" id="price" name="price" class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer" placeholder="Enter price here"
                        value="{{ old('price') }}" required>
                    <label for="price" class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                        Price (in IDR)
                    </label>
                </div>
                @error('price')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <textarea id="description" name="description" class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200 placeholder:text-transparent peer" rows="4" placeholder="Enter description here">{{ old('description') }}</textarea>
                    <label for="description" class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-slate-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                        Description
                    </label>
                </div>
                @error('description')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="limited_edition">Limited Edition</label>
                <div class="flex items-center gap-4">
                    <label class="flex items-center">
                        <input type="radio" id="limited_edition_yes" name="limited_edition" value="1" checked
                            class="input-primary" {{ old('limited_edition') == '1' ? 'checked' : '' }} required>
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" id="limited_edition_no" name="limited_edition" value="0"
                            class="input-primary" {{ old('limited_edition') == '0' ? 'checked' : '' }} required>
                        <span class="ml-2">No</span>
                    </label>
                </div>
                @error('limited_edition')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <select name="size" id="size" required
                            class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200">
                        <option value="" disabled selected>Select size</option>
                        <option value="XS" {{ old('size') == 'XS' ? 'selected' : '' }}>XS</option>
                        <option value="S" {{ old('size') == 'S' ? 'selected' : '' }}>S</option>
                        <option value="M" {{ old('size') == 'M' ? 'selected' : '' }}>M</option>
                        <option value="L" {{ old('size') == 'L' ? 'selected' : '' }}>L</option>
                        <option value="XL" {{ old('size') == 'XL' ? 'selected' : '' }}>XL</option>
                        <option value="XXL" {{ old('size') == 'XXL' ? 'selected' : '' }}>XXL</option>
                    </select>
                    <label for="size" class="absolute text-sm font-medium text-slate-500 duration-200 transform -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white px-2">
                        Size
                    </label>
                </div>
            </div>

            <div class="relative group p-6 bg-white rounded-lg border border-slate-200/70">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <label class="text-sm font-medium text-slate-800 mb-3 block">Colors</label>
                    <div class="grid grid-cols-3 gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="color[]" value="Red" class="input-primary"
                                {{ is_array(old('color')) && in_array('Red', old('color')) ? 'checked' : '' }}>
                            <span class="ml-2">Red</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="color[]" value="Blue" class="input-primary"
                                {{ is_array(old('color')) && in_array('Blue', old('color')) ? 'checked' : '' }}>
                            <span class="ml-2">Blue</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="color[]" value="Green" class="input-primary"
                                {{ is_array(old('color')) && in_array('Green', old('color')) ? 'checked' : '' }}>
                            <span class="ml-2">Green</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="color[]" value="Yellow" class="input-primary"
                                {{ is_array(old('color')) && in_array('Yellow', old('color')) ? 'checked' : '' }}>
                            <span class="ml-2">Yellow</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="color[]" value="Black" class="input-primary"
                                {{ is_array(old('color')) && in_array('Black', old('color')) ? 'checked' : '' }}>
                            <span class="ml-2">Black</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="color[]" value="White" class="input-primary"
                                {{ is_array(old('color')) && in_array('White', old('color')) ? 'checked' : '' }}>
                            <span class="ml-2">White</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="relative group p-6 bg-white rounded-lg border border-slate-200/70">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <label class="text-sm font-medium text-slate-800 mb-3 block">Category</label>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach ($categories as $category)
                            <label class="flex items-center">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="input-primary" {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
                                <span class="ml-2">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative">
                    <input type="file" id="image" name="image" class="block w-full px-4 py-3 bg-white border border-slate-200/70 rounded-lg focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition-all duration-200"
                        onchange="previewImage(event)">
                    <img id="image-preview" src="#" alt="Image Preview"
                        class="w-32 h-32 rounded-2xl object-cover mt-2 hidden">
                </div>
                @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end gap-4 pt-6">
                <a href="{{ route('admin.clothes.index') }}" 
                   class="relative inline-flex items-center justify-center px-6 py-3 text-base font-medium text-slate-700 bg-white hover:bg-slate-50 rounded-xl shadow-sm transition-all duration-200 hover:translate-y-[-2px] hover:shadow-md group">
                    <span class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-xl blur opacity-0 group-hover:opacity-75 transition duration-1000"></span>
                    Cancel
                </a>
                <button type="submit" 
                        class="relative inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-gradient-to-r from-slate-800 to-slate-900 rounded-xl hover:from-slate-900 hover:to-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transform transition-all duration-200 hover:shadow-[0_0_20px_-3px_rgba(0,0,0,0.2)] hover:-translate-y-0.5">
                    Add Clothes
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
                output.classList.remove('hidden');
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
        const token = localStorage.getItem('token') || getCookie('token');
        
        const response = await fetch(this.action, {
            method: 'POST',
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
            alert(data.message || 'Failed to create clothes');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    } finally {
        submitBtn.disabled = false;
    }
});

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
</script>
@endpush
