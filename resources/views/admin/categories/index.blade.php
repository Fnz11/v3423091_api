@extends('layouts.admin')

@section('title', 'Manage Categories')
@section('page-title', 'Categories Management')

@push('styles')
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes scaleIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .content-container {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.7);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.18);
        animation: scaleIn 0.6s ease-out;
    }

    .category-row {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 12px;
        transition: all 0.3s ease;
        animation: fadeIn 0.5s ease-out;
    }

    .category-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .action-button {
        @apply p-2 rounded-xl transition-all duration-300;
    }

    .action-button:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="content-container p-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
            <p class="text-gray-500 mt-1">Manage your product categories</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" 
           class="px-6 py-3 gradient-primary text-white rounded-xl hover:scale-105 transition-all shadow-lg shadow-purple-500/20">
            <i class="fas fa-plus mr-2"></i> Add Category
        </a>
    </div>

    <div class="grid gap-4">
        @forelse ($categories as $index => $category)
            <div class="category-row p-4" style="animation-delay: {{ $index * 0.1 }}s">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center text-white font-bold">
                            {{ substr($category->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-500">ID: {{ $category->id }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                            class="text-slate-400 hover:text-slate-700 hover:scale-[1.05] transition-all duration-500 ease-out flex items-center justify-center w-3 h-3 rounded-full">
                            <x-zondicon-edit-pencil />
                        </a>
                        <button type="button" onclick="confirmDelete({{ $category->id }})"
                            class="text-red-400 hover:text-red-500 hover:scale-[1.05] transition-all duration-500 ease-out flex items-center justify-center w-3 h-3 rounded-full">
                            <x-zondicon-trash />
                        </button>
                        <form id="delete-form-{{ $category->id }}"
                            action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                            class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                No categories found. Start by adding one!
            </div>
        @endforelse
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-slate-800 bg-opacity-50 flex items-center justify-center modal hidden">
    <div class="bg-white rounded-2xl shadow-xl shadow-slate-400 p-6 w-1/3">
        <h2 class="text-xl font-semibold mb-4">Confirm Deletion</h2>
        <p class="mb-6">Are you sure you want to delete this item?</p>
        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeModal()" class="btn-secondary">Cancel</button>
            <button type="button" onclick="submitDelete()" class="btn-primary">Delete</button>
        </div>
    </div>
</div>

<script>
    let deleteFormId = null;

    function confirmDelete(id) {
        deleteFormId = id;
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('hidden');
        modal.classList.add('visible');
    }

    function closeModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('visible');
        modal.classList.add('hidden');
    }

    function submitDelete() {
        if (deleteFormId) {
            document.getElementById('delete-form-' + deleteFormId).submit();
        }
    }
</script>
@endsection
