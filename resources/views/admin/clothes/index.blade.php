@extends('layouts.admin')

@section('title', 'Manage Clothes')
@section('page-title', 'Clothes Management')

@section('content')
    <div class="bg-white shadow-2xl shadow-slate-200 h-full rounded-2xl overflow-hidden p-6 flex flex-col gap-3">
        <div class="w-full flex justify-between">
            <div class="flex flex-col">
                <h1 class="font-semibold text-lg">All Clothes</h1>
                <p class="text-slate-500 text-base">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iste
                    cupiditate!</p>
            </div>
            <a href="{{ route('admin.clothes.create') }}" class="btn-primary !py-0 h-8">Add New
                Clothes</a>
        </div>
        <div class="overflow-x-auto mt-10">
            <table class="min-w-full bg-white">
                <thead class="border-b border-slate-200">
                    <tr>
                        <x-table.head-coll>Image</x-table.head-coll>
                        <x-table.head-coll>ID</x-table.head-coll>
                        <x-table.head-coll>Name</x-table.head-coll>
                        <x-table.head-coll>Description</x-table.head-coll>
                        <x-table.head-coll>Price</x-table.head-coll>
                        <x-table.head-coll>Stock</x-table.head-coll>
                        <x-table.head-coll>Categories</x-table.head-coll> <!-- New column for categories -->
                        <x-table.head-coll>Action</x-table.head-coll>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clothes as $cloth)
                        <tr class="border-b">
                            <td class="py-2 px-4">
                                <img src="{{ asset('storage/images/clothes/' . $cloth->image) }}" alt="{{ $cloth->name }}"
                                    class="w-14 h-14 object-cover rounded-2xl shadow-xl ">
                            </td>
                            <td class="py-2 px-4">{{ $cloth->id }}</td>
                            <td class="py-2 px-4">{{ $cloth->name }}</td>
                            <td class="py-2 px-4">{{ $cloth->description }}</td>
                            <td class="py-2 px-4">{{ formatRupiah($cloth->price) }}</td>
                            <td class="py-2 px-4">{{ $cloth->stock }}</td>
                            <td class="py-2 px-4">
                                @foreach ($cloth->categories as $category)
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">{{ $category->name }}</span>
                                @endforeach
                            </td>
                            <td class="space-x-2 flex mt-4 items-center justify-center">
                                <a href="{{ route('admin.clothes.show', $cloth->id) }}"
                                    class="text-slate-400 hover:text-slate-700 hover:scale-[1.05] transition-all duration-500 ease-out flex items-center justify-center w-4 h-4 rounded-full">
                                    <x-zondicon-view-show />
                                </a>
                                <a href="{{ route('admin.clothes.edit', $cloth->id) }}"
                                    class="text-slate-400 hover:text-slate-700 hover:scale-[1.05] transition-all duration-500 ease-out flex items-center justify-center w-3 h-3 rounded-full">
                                    <x-zondicon-edit-pencil />
                                </a>
                                <button type="button" onclick="confirmDelete({{ $cloth->id }})"
                                    class="text-red-400 hover:text-red-500 hover:scale-[1.05] transition-all duration-500 ease-out flex items-center justify-center w-3 h-3 rounded-full">
                                    <x-zondicon-trash />
                                </button>
                                <form id="delete-form-{{ $cloth->id }}"
                                    action="{{ route('admin.clothes.destroy', $cloth->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-4 text-center font-medium">Products not found, please add product
                                first.</td>
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
