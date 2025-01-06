@extends('layouts.admin')

@section('title', 'Manage Clothes')
@section('page-title', 'Clothes Management')

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

    .table-row {
        background: rgba(255, 255, 255, 0.9);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: fadeIn 0.5s ease-out;
    }

    .table-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .product-image {
        transition: transform 0.3s ease;
    }

    .product-image:hover {
        transform: scale(1.1) rotate(2deg);
    }

    .action-button {
        transition: all 0.3s ease;
    }

    .action-button:hover {
        transform: translateY(-2px);
    }

    .category-tag {
        background: linear-gradient(145deg, #f6f8fc, #ffffff);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .category-tag:hover {
        transform: translateY(-1px) scale(1.05);
    }
</style>
@endpush

@section('content')
<div class="content-container p-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">All Clothes</h1>
            <p class="text-gray-500 mt-1">Manage your clothing inventory</p>
        </div>
        <a href="{{ route('admin.clothes.create') }}" 
           class="px-6 py-3 gradient-primary text-white rounded-xl hover:scale-105 transition-all shadow-lg shadow-purple-500/20">
            <i class="fas fa-plus mr-2"></i> Add New Clothes
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <x-table.head-coll>Image</x-table.head-coll>
                    <x-table.head-coll>ID</x-table.head-coll>
                    <x-table.head-coll>Name</x-table.head-coll>
                    <x-table.head-coll>Description</x-table.head-coll>
                    <x-table.head-coll>Price</x-table.head-coll>
                    <x-table.head-coll>Stock</x-table.head-coll>
                    <x-table.head-coll>Categories</x-table.head-coll>
                    <x-table.head-coll>Action</x-table.head-coll>
                </tr>
            </thead>
            <tbody class="space-y-4">
                @forelse ($clothes as $index => $cloth)
                    <tr class="table-row" style="animation-delay: {{ $index * 0.1 }}s">
                        <td class="p-4">
                            <img src="{{ asset('storage/images/clothes/' . $cloth->image) }}" 
                                 class="product-image w-16 h-16 rounded-xl object-cover"
                                 alt="{{ $cloth->name }}">
                        </td>
                        <td class="py-2 px-4">{{ $cloth->id }}</td>
                        <td class="py-2 px-4">{{ $cloth->name }}</td>
                        <td class="py-2 px-4">{{ $cloth->description }}</td>
                        <td class="py-2 px-4">{{ formatRupiah($cloth->price) }}</td>
                        <td class="py-2 px-4">{{ $cloth->stock }}</td>
                        <td class="p-4">
                            <div class="flex gap-2 flex-wrap">
                                @foreach ($cloth->categories as $category)
                                    <span class="category-tag px-3 py-1 rounded-full text-sm text-purple-600">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.clothes.show', $cloth->id) }}"
                                    class="action-button text-slate-400 hover:text-slate-700 hover:scale-[1.05] transition-all duration-500 ease-out flex items-center justify-center w-4 h-4 rounded-full">
                                    <x-zondicon-view-show />
                                </a>
                                <a href="{{ route('admin.clothes.edit', $cloth->id) }}"
                                    class="action-button text-slate-400 hover:text-slate-700 hover:scale-[1.05] transition-all duration-500 ease-out flex items-center justify-center w-3 h-3 rounded-full">
                                    <x-zondicon-edit-pencil />
                                </a>
                                <button type="button" onclick="confirmDelete({{ $cloth->id }})"
                                    class="action-button text-red-400 hover:text-red-500 hover:scale-[1.05] transition-all duration-500 ease-out flex items-center justify-center w-3 h-3 rounded-full">
                                    <x-zondicon-trash />
                                </button>
                                <form id="delete-form-{{ $cloth->id }}"
                                    action="{{ route('admin.clothes.destroy', $cloth->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-500">
                            No clothes found. Start by adding some!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
