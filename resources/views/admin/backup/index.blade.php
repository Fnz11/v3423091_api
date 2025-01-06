@php
    use App\Models\Backup;
@endphp

@extends('layouts.admin')

@section('title', 'Backup Management')

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

    .backup-row {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 12px;
        transition: all 0.3s ease;
        animation: fadeIn 0.5s ease-out;
    }

    .backup-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
<div class="content-container p-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Backup Management</h1>
            <p class="text-gray-500 mt-1">Manage your database and project backups</p>
        </div>
    </div>

    <div id="alert-container"></div>

    <div class="grid gap-8 grid-cols-1 lg:grid-cols-2">
        <!-- Database Backups -->
        <div class="space-y-4">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <i class="fas fa-database text-2xl text-blue-500"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Database Backups</h2>
                        <p class="text-gray-600">Manage your database backups</p>
                    </div>
                </div>
                <form action="{{ route('admin.backup.database') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-3 gradient-primary text-white rounded-xl hover:scale-105 transition-all shadow-lg shadow-blue-500/20">
                        <i class="fas fa-plus mr-2"></i>Create Backup
                    </button>
                </form>
            </div>

            @forelse($databaseBackups as $index => $backup)
                <div class="backup-row p-4" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $backup->name }}</h3>
                            <p class="text-sm text-gray-500">
                                Size: {{ $backup->size }} • {{ $backup->created_at->diffForHumans() }}
                                @if($backup->status === 'pending')
                                    <span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Processing...</span>
                                @endif
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($backup->is_completed)
                                <a href="{{ route('admin.backup.download', $backup) }}" 
                                   class="text-blue-500 hover:text-blue-600 hover:scale-110 transition-all">
                                    <i class="fas fa-download"></i>
                                </a>
                                @if($backup->isRestoring())
                                    <span class="text-yellow-500">
                                        <i class="fas fa-sync fa-spin"></i>
                                    </span>
                                @else
                                    <button onclick="confirmRestore({{ $backup->id }})" 
                                            class="text-green-500 hover:text-green-600 hover:scale-110 transition-all">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                @endif
                                <button onclick="confirmDelete({{ $backup->id }})" 
                                        class="text-red-500 hover:text-red-600 hover:scale-110 transition-all">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    No backups available. Start by creating one!
                </div>
            @endforelse
        </div>

        <!-- Project Backup -->
        <div class="space-y-4">
            <div class="flex items-center gap-4 mb-6">
                <div class="p-3 bg-purple-50 rounded-xl">
                    <i class="fas fa-file-archive text-2xl text-purple-500"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Project Backup</h2>
                    <p class="text-gray-600">Download project files backup</p>
                </div>
            </div>
            <div class="backup-row p-6">
                <p class="text-gray-600 mb-6">Creates a ZIP archive containing all project files (excluding vendor and node_modules).</p>
                <a href="{{ route('admin.backup.project') }}" 
                   class="inline-flex items-center justify-center w-full px-6 py-4 text-white gradient-primary rounded-xl hover:scale-105 transition-all shadow-lg shadow-purple-500/20">
                    <i class="fas fa-download mr-2"></i>
                    Download Project Backup
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-slate-800 bg-opacity-50 flex items-center justify-center modal hidden">
    <div class="bg-white rounded-2xl shadow-xl shadow-slate-400 p-6 w-1/3">
        <h2 class="text-xl font-semibold mb-4">Confirm Deletion</h2>
        <p class="mb-6">Are you sure you want to delete this backup?</p>
        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeModal()" class="btn-secondary">Cancel</button>
            <button type="button" onclick="submitDelete()" class="btn-primary">Delete</button>
        </div>
    </div>
</div>

<!-- Restore Confirmation Modal -->
<div id="restore-modal" class="fixed inset-0 bg-slate-800 bg-opacity-50 flex items-center justify-center modal hidden">
    <div class="bg-white rounded-2xl shadow-xl shadow-slate-400 p-6 w-1/3">
        <h2 class="text-xl font-semibold mb-4">Confirm Restore</h2>
        <p class="mb-6">Are you sure you want to restore this backup? This will override your current database.</p>
        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeRestoreModal()" class="btn-secondary">Cancel</button>
            <button type="button" onclick="submitRestore()" class="btn-primary">Restore</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentBackupId = null;

    function showAlert(message, type = 'success') {
        const alertContainer = document.getElementById('alert-container');
        const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';

        alertContainer.innerHTML = `
            <div class="alert alert-${type} fixed top-5 left-1/2 translate-x-[-50%] flex gap-5 z-[1000] bg-white p-4 rounded-xl shadow-lg">
                <div class="flex items-center gap-2 ${type === 'success' ? 'text-green-600' : 'text-red-600'}">
                    <i class="fas fa-${icon}"></i>
                    ${message}
                </div>
                <button type="button" class="hover:opacity-75" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

        setTimeout(() => {
            const alert = alertContainer.querySelector('.alert');
            if (alert) alert.remove();
        }, 3000);
    }

    function confirmDelete(id) {
        currentBackupId = id;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function confirmRestore(id) {
        currentBackupId = id;
        document.getElementById('restore-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('delete-modal').classList.add('hidden');
        currentBackupId = null;
    }

    function closeRestoreModal() {
        document.getElementById('restore-modal').classList.add('hidden');
        currentBackupId = null;
    }

    function submitDelete() {
        if (currentBackupId) {
            fetch(`/admin/backup/${currentBackupId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json())
              .then(data => {
                  showAlert(data.message || 'Backup deleted successfully');
                  setTimeout(() => window.location.reload(), 1000);
              })
              .catch(error => showAlert('Error deleting backup', 'error'));
        }
        closeModal();
    }

    function submitRestore() {
        if (currentBackupId) {
            window.location.href = `/admin/backup/${currentBackupId}/restore`;
        }
        closeRestoreModal();
    }

    // Existing auto-refresh logic
    @if($databaseBackups->where('restore_status', 'restoring')->count() > 0)
        let checkCount = 0;
        const maxChecks = 10; // Reduce max checks to 10 attempts (50 seconds)
        
        function checkStatus() {
            fetch('/admin/backup/check-restore-status')
                .then(response => response.json())
                .then(data => {
                    if (!data.isRestoring || checkCount >= maxChecks) {
                        window.location.reload();
                        return;
                    }
                    checkCount++;
                    setTimeout(checkStatus, 5000);
                })
                .catch(() => window.location.reload());
        }
        
        setTimeout(checkStatus, 5000);
    @endif
</script>
@endpush
@endsection
