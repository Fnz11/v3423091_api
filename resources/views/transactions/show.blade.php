@extends('layouts.admin')

@section('title', 'Transaction Details')

@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        .animate-scaleIn {
            animation: scaleIn 0.6s ease-out;
        }
    </style>
@endpush

@section('content')
    <div id="alert-container"></div>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-4xl font-bold mb-8 text-gray-800 tracking-tight">Transaction Details</h1>

        <div class="backdrop-blur-lg bg-white/70 rounded-3xl p-6 animate-scaleIn shadow-xl">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Order #{{ $transaction->id }}</h2>
                <span
                    class="px-4 py-2 inline-flex items-center gap-2 rounded-xl font-medium
                @if ($transaction->status === 'pending') bg-yellow-100 text-yellow-700
                @elseif($transaction->status === 'success') bg-green-100 text-green-700
                @elseif($transaction->status === 'failed') bg-red-100 text-red-700
                @else bg-gray-100 text-gray-700 @endif">
                    <i
                        class="fas fa-{{ $transaction->status === 'pending'
                            ? 'clock'
                            : ($transaction->status === 'success'
                                ? 'check-circle'
                                : ($transaction->status === 'failed'
                                    ? 'times-circle'
                                    : 'circle')) }}"></i>
                    {{ ucfirst($transaction->status) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-8 mb-8">
                @if (auth()->user()->isAdmin())
                    <div class="bg-white/90 rounded-2xl p-6 animate-fadeIn shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                            <i class="fas fa-user-circle text-blue-400"></i>
                            Customer Details
                        </h3>
                        <div class="space-y-2">
                            <p><span class="text-gray-600">Name:</span> {{ $transaction->user->name }}</p>
                            <p><span class="text-gray-600">Email:</span> {{ $transaction->user->email }}</p>
                        </div>
                    </div>
                @endif

                <div class="bg-white/90 rounded-2xl p-6 animate-fadeIn shadow-sm hover:shadow-md transition-shadow">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-wallet text-green-400"></i>
                        Payment Details
                    </h3>
                    <div class="space-y-2">
                        <p><span class="text-gray-600">Method:</span>
                            {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</p>
                        <p><span class="text-gray-600">Amount:</span> Rp {{ number_format($transaction->total_amount, 2) }}
                        </p>
                        <p><span class="text-gray-600">Due:</span> {{ $transaction->payment_due->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="payment-info bg-white p-4 rounded-lg shadow mb-4">
                <h3 class="text-lg font-semibold mb-3">Payment Information</h3>
                <div class="payment-token bg-gray-100 p-3 rounded">
                    <p class="font-medium">Payment Token:</p>
                    <p class="text-2xl font-bold text-primary">{{ $transaction->payment_token }}</p>
                </div>
                <div class="mt-3">
                    <p class="text-sm text-gray-600">Please use this token when making your payment</p>
                    <p class="text-sm text-gray-600">Payment Due: {{ $transaction->payment_due->format('d M Y H:i') }}</p>
                </div>
            </div>

            <div class="bg-white/90 rounded-2xl p-6 mb-8 animate-fadeIn shadow-sm hover:shadow-md transition-shadow">
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <i class="fas fa-truck text-purple-400"></i>
                    Shipping Address
                </h3>
                <div class="space-y-2">
                    <p>{{ $transaction->shipping_address['street'] }}</p>
                    <p>{{ $transaction->shipping_address['city'] }}</p>
                    <p>{{ $transaction->shipping_address['postal_code'] }}</p>
                </div>
            </div>

            <div class="bg-white/90 rounded-2xl overflow-hidden animate-fadeIn shadow-sm">
                <table class="w-full border-separate border-spacing-y-4">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Item</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Price</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Quantity</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->items as $item)
                            <tr class="hover:bg-gray-50/50 transition-all duration-300">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ asset('storage/images/clothes/' . $item->clothes->image) }}"
                                            class="w-16 h-16 object-cover rounded-xl transition-transform duration-300 hover:scale-110 hover:rotate-2 shadow-md">
                                        <span class="font-medium text-gray-700">{{ $item->clothes->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">Rp {{ number_format($item->price, 2) }}</td>
                                <td class="px-6 py-4">{{ $item->quantity }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50/50">
                            <td colspan="3" class="px-6 py-4 text-right font-semibold">Total Amount:</td>
                            <td colspan="2" class="px-6 py-4 font-bold text-xl text-gray-800">
                                Rp {{ number_format($transaction->total_amount, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-8 flex justify-between items-center">
                <a href="{{ auth()->user()->isAdmin() ? route('admin.transactions.index') : route('user.transactions.index') }}"
                    class="bg-white hover:bg-gray-50 px-6 py-3 rounded-xl font-medium shadow-sm transition-all duration-300 hover:translate-y-[-2px] hover:shadow-md inline-flex items-center gap-2">
                    <i class="fas fa-arrow-left text-gray-400"></i>
                    Back to Transactions
                </a>

                @if ($transaction->status === 'pending')
                    @if (auth()->user()->isAdmin())
                        <div class="flex gap-4">
                            <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST"
                                class="status-form">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="success">
                                <button type="submit" id="approveBtn"
                                    class="btn-loading-state relative w-full inline-flex items-center justify-center px-6 py-4 text-base font-medium text-white bg-gradient-to-r from-green-500 to-green-600 rounded-xl transform transition-all duration-200">
                                    <span class="button-content flex items-center space-x-2">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Approve Payment</span>
                                    </span>
                                    <span class="loading-indicator">
                                        <div class="loading-dots-premium inline-flex space-x-1">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </span>
                                </button>
                            </form>
                            <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST"
                                class="status-form">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="failed">
                                <button type="submit" id="rejectBtn"
                                    class="btn-loading-state relative w-full inline-flex items-center justify-center px-6 py-4 text-base font-medium text-white bg-gradient-to-r from-red-500 to-red-600 rounded-xl transform transition-all duration-200">
                                    <span class="button-content flex items-center space-x-2">
                                        <i class="fas fa-times-circle"></i>
                                        <span>Reject Payment</span>
                                    </span>
                                    <span class="loading-indicator">
                                        <div class="loading-dots-premium inline-flex space-x-1">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </span>
                                </button>
                            </form>
                        </div>
                    @elseif($transaction->canBeCancelled())
                        <form action="{{ route('user.transactions.cancel', $transaction) }}" method="POST"
                            class="status-form">
                            @csrf
                            <button type="submit" id="cancelBtn"
                                class="btn-loading-state relative w-full inline-flex items-center justify-center px-6 py-4 text-base font-medium text-white bg-gradient-to-r from-red-500 to-red-600 rounded-xl transform transition-all duration-200">
                                <span class="button-content flex items-center space-x-2">
                                    <i class="fas fa-ban"></i>
                                    <span>Cancel Order</span>
                                </span>
                                <span class="loading-indicator">
                                    <div class="loading-dots-premium inline-flex space-x-1">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </span>
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
        <!-- Action Confirmation Modal -->
        <div id="action-modal"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center modal hidden z-50">
            <div
                class="bg-white/95 rounded-2xl shadow-xl p-8 w-full max-w-md transform transition-all scale-95 opacity-0 modal-content">
                <div class="text-center">
                    <div id="modal-icon" class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    </div>
                    <h2 id="modal-title" class="text-2xl font-bold text-gray-800 mb-4"></h2>
                    <p id="modal-message" class="text-gray-600 mb-8 text-lg"></p>
                    <div class="flex gap-4 justify-center">
                        <button type="button" onclick="closeActionModal()"
                            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-all duration-200 hover:-translate-y-0.5">
                            Cancel
                        </button>
                        <button type="button" id="confirm-action-btn"
                            class="px-6 py-3 rounded-xl font-medium hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = getCookie('token') || localStorage.getItem('token');
            if (!token) {
                window.location.replace('/login');
                return;
            }

            // Add token to all forms
            document.querySelectorAll('.status-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
                            },
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                if (response.status === 401) {
                                    window.location.replace('/login');
                                    throw new Error('Please login again');
                                }
                                throw new Error('Action failed');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert(error.message);
                        });
                });
            });

            const actionModal = document.getElementById('action-modal');
            const modalContent = actionModal.querySelector('.modal-content');
            let currentForm = null;

            function showAlert(message, type = 'success') {
                const alertContainer = document.getElementById('alert-container');
                const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
                const bgColor = type === 'success' ? 'bg-green-50' : 'bg-red-50';
                const textColor = type === 'success' ? 'text-green-800' : 'text-red-800';
                const borderColor = type === 'success' ? 'border-green-200' : 'border-red-200';

                const alert = `
            <div class="fixed top-5 left-1/2 -translate-x-1/2 z-50 animate-fadeIn">
                <div class="flex items-center gap-2 px-6 py-3 ${bgColor} ${textColor} rounded-xl border ${borderColor} shadow-lg">
                    <i class="fas fa-${icon}"></i>
                    <span>${message}</span>
                </div>
            </div>
        `;

                alertContainer.innerHTML = alert;
                setTimeout(() => {
                    const alertElement = alertContainer.firstChild;
                    if (alertElement) {
                        alertElement.style.opacity = '0';
                        setTimeout(() => alertElement.remove(), 300);
                    }
                }, 3000);
            }

            function showActionModal(config, form) {
                currentForm = form;
                const {
                    title,
                    message,
                    buttonText,
                    buttonClass,
                    iconClass,
                    icon
                } = config;

                document.getElementById('modal-title').textContent = title;
                document.getElementById('modal-message').textContent = message;
                document.getElementById('modal-icon').className =
                    `w-20 h-20 rounded-full ${iconClass} flex items-center justify-center mx-auto mb-6`;
                document.getElementById('modal-icon').innerHTML = icon;

                const confirmBtn = document.getElementById('confirm-action-btn');
                confirmBtn.textContent = buttonText;
                confirmBtn.className =
                    `px-6 py-3 ${buttonClass} rounded-xl font-medium hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200`;

                actionModal.classList.remove('hidden');
                setTimeout(() => modalContent.classList.remove('scale-95', 'opacity-0'), 10);
            }

            function closeActionModal() {
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => actionModal.classList.add('hidden'), 200);
            }

            const modalConfig = {
                approve: {
                    title: 'Approve Payment',
                    message: 'Are you sure you want to approve this payment?',
                    buttonText: 'Approve',
                    buttonClass: 'bg-gradient-to-r from-green-500 to-green-600 text-white',
                    iconClass: 'bg-green-50',
                    icon: '<i class="fas fa-check-circle text-3xl text-green-500"></i>'
                },
                reject: {
                    title: 'Reject Payment',
                    message: 'Are you sure you want to reject this payment?',
                    buttonText: 'Reject',
                    buttonClass: 'bg-gradient-to-r from-red-500 to-red-600 text-white',
                    iconClass: 'bg-red-50',
                    icon: '<i class="fas fa-times-circle text-3xl text-red-500"></i>'
                },
                cancel: {
                    title: 'Cancel Order',
                    message: 'Are you sure you want to cancel this order?',
                    buttonText: 'Cancel Order',
                    buttonClass: 'bg-gradient-to-r from-red-500 to-red-600 text-white',
                    iconClass: 'bg-red-50',
                    icon: '<i class="fas fa-ban text-3xl text-red-500"></i>'
                }
            };

            document.querySelectorAll('.status-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const status = this.querySelector('input[name="status"]')?.value || 'cancel';
                    const config = status === 'success' ? modalConfig.approve :
                        status === 'failed' ? modalConfig.reject :
                        modalConfig.cancel;

                    showActionModal(config, this);
                });
            });

            // Handle confirm button click
            document.getElementById('confirm-action-btn').addEventListener('click', function() {
                if (currentForm) {
                    const submitBtn = currentForm.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                    submitBtn.disabled = true;

                    // Get form data including _method field
                    const formData = new FormData(currentForm);

                    fetch(currentForm.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                            },
                            body: formData // Send FormData directly
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            // Handle both JSON and non-JSON responses
                            const contentType = response.headers.get("content-type");
                            if (contentType && contentType.includes("application/json")) {
                                return response.json();
                            }
                            return {
                                success: true,
                                message: 'Status updated successfully'
                            };
                        })
                        .then(data => {
                            showAlert(data.message || 'Status updated successfully', 'success');
                            setTimeout(() => window.location.reload(), 1000);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('An error occurred', 'error');
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        });

                    closeActionModal();
                }
            });

            // Close modal on backdrop click
            actionModal.addEventListener('click', function(e) {
                if (e.target === actionModal) {
                    closeActionModal();
                }
            });
        });
    </script>

    <style>
        .modal {
            transition: all 0.3s ease-in-out;
        }

        .modal-content {
            transition: all 0.2s ease-out;
        }

        .hidden {
            visibility: hidden;
            opacity: 0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
@endpush
