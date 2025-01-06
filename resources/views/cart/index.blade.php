@extends('layouts.admin')

@section('title', 'Cart')
@section('page-title', 'Cart')

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
    <div class="w-full mx-auto">
        <h1 class="text-4xl font-bold mb-8 text-gray-800 tracking-tight">Shopping Cart</h1>

        <div id="alert-container"></div>

        @if ($cart->items->count() > 0)
            <div class="backdrop-blur-lg bg-white/70 rounded-3xl content-container p-5 animate-scaleIn">
                <div class="scrollbar-hide">
                    <table class="w-full border-separate border-spacing-y-4">
                        <thead>
                            <tr class="text-left text-gray-600">
                                <th class="px-6 py-4">Product</th>
                                <th class="px-6 py-4">Price</th>
                                <th class="px-6 py-4">Quantity</th>
                                <th class="px-6 py-4">Subtotal</th>
                                <th class="px-6 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart->items as $item)
                                <tr class="bg-white/90 rounded-2xl transition-all duration-300 hover:translate-y-[-5px] hover:scale-[1.01] hover:shadow-lg animate-fadeIn"
                                    data-item-id="{{ $item->id }}">
                                    <td class="px-6 py-4 flex items-center gap-4">
                                        <img src="{{ asset('storage/images/clothes/' . $item->clothes->image) }}" 
                                        class="w-16 h-16 object-cover rounded-xl transition-transform duration-300 hover:scale-110 hover:rotate-2 shadow-md"
                                            alt="{{ $item->clothes->name }}">
                                        <span class="font-semibold text-gray-800">{{ $item->clothes->name }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-700">Rp {{ number_format($item->price, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="bg-white/90 rounded-xl p-2 shadow-sm inline-flex items-center gap-2">
                                            <button type="button"
                                                class="bg-gradient-to-r from-gray-50 to-white w-8 h-8 rounded-lg flex items-center justify-center font-semibold text-gray-600 transition-all hover:translate-y-[-2px] hover:from-white hover:to-gray-50 minus-btn"
                                                data-item-id="{{ $item->id }}"><i class="fas fa-minus"></i></button>
                                            <input type="number"
                                                class="w-12 text-center border-none bg-transparent font-semibold text-gray-800 quantity-input"
                                                value="{{ $item->quantity }}" min="1"
                                                data-item-id="{{ $item->id }}" data-price="{{ $item->price }}">
                                            <button type="button"
                                                class="bg-gradient-to-r from-gray-50 to-white w-8 h-8 rounded-lg flex items-center justify-center font-semibold text-gray-600 transition-all hover:translate-y-[-2px] hover:from-white hover:to-gray-50 plus-btn"
                                                data-item-id="{{ $item->id }}"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-gray-800 subtotal">
                                            Rp {{ number_format($item->subtotal, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button
                                            class="bg-gradient-to-r from-red-200 to-red-100 px-4 py-2 rounded-lg text-red-600 font-medium transition-all hover:translate-y-[-2px] hover:from-red-100 hover:to-red-200 remove-btn"
                                            data-item-id="{{ $item->id }}">
                                            <i class="fas fa-trash-alt mr-2"></i> Remove
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right">
                                    <span class="text-xl font-semibold text-gray-700">Total:</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xl font-bold text-gray-900" id="cart-total-amount">
                                        Rp {{ number_format($cart->total_amount, 2) }}
                                    </span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="flex justify-end gap-4 mt-8">
                    <a href="/products" class="px-6 py-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                        <i class="fas fa-arrow-left mr-2"></i> Continue Shopping
                    </a>
                    @if ($cart->items->count() > 0)
                        <a href="{{ route('checkout.index') }}"
                            class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:translate-y-[-3px] shadow-blue-500/20 hover:shadow-lg">
                            <i class="fas fa-shopping-cart mr-2"></i> Proceed to Checkout
                        </a>
                    @endif
                </div>
            </div>
        @else
            <div class="text-center py-16 px-8 bg-white/80 rounded-3xl animate-scaleIn">
                <p class="text-xl text-gray-600 mb-6">Your cart is empty</p>
                <a href="/products"
                    class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-4 rounded-xl font-semibold inline-block transition-all duration-300 hover:translate-y-[-3px] shadow-blue-500/20 hover:shadow-lg">Start
                    Shopping</a>
            </div>
        @endif
    </div>

    <div id="delete-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center modal hidden z-50">
        <div class="bg-white/90 rounded-2xl shadow-xl p-6 w-full max-w-md transform transition-all scale-95 opacity-0 modal-content">
            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Remove Item</h2>
                <p class="text-gray-600 mb-6">Are you sure you want to remove this item from your cart?</p>
                <div class="flex gap-3 justify-center">
                    <button type="button" onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-200">
                        Cancel
                    </button>
                    <button type="button" id="confirm-delete-btn"
                        class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        Remove Item
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check for JWT token
                const token = getCookie('token') || localStorage.getItem('token');
                if (!token) {
                    window.location.replace('/login');
                    return;
                }

                // Add token to all fetch requests
                const headers = {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                };

                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                function showAlert(message, type = 'success') {
                    const alertContainer = document.getElementById('alert-container');
                    const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';

                    alertContainer.innerHTML = `
                        <div class="alert alert-${type} fixed top-5 left-1/2 translate-x-[-1/2] flex gap-5 z-[1000]">
                            <div>
                                <i class="fas fa-${icon} mr-2"></i>
                                ${message}
                            </div>
                            <button type="button" class="text-${type === 'success' ? 'green' : 'red'}-800 hover:opacity-75" onclick="this.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;

                    // Auto-remove after 3 seconds
                    setTimeout(() => {
                        const alert = alertContainer.querySelector('.alert');
                        if (alert) {
                            alert.remove();
                        }
                    }, 3000);
                }

                // Add debounce utility function
                function debounce(func, wait) {
                    let timeout;
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(timeout);
                            func(...args);
                        };
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                    };
                }

                // Debounced version of updateCart
                const debouncedUpdateCart = debounce((itemId, quantity) => {
                    fetch(`/cart/update/${itemId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                quantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success === true) {
                                try {
                                    // Update subtotal
                                    const subtotalElement = document.querySelector(
                                        `tr[data-item-id="${itemId}"] .subtotal`);
                                    if (subtotalElement) {
                                        subtotalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID')
                                            .format(data.subtotal) + ".00";
                                    }

                                    // Update total
                                    const totalElement = document.getElementById('cart-total-amount');
                                    if (totalElement) {
                                        totalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID')
                                            .format(data.total) + ".00";
                                    }

                                    showAlert('Cart updated successfully');
                                } catch (err) {
                                    console.error('DOM update error:', err);
                                    showAlert('Error updating display', 'danger');
                                }
                            } else {
                                showAlert(data.message || 'Update failed', 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Network error:', error);
                            showAlert('Error updating cart', 'danger');
                        });
                }, 500); // 500ms debounce delay

                function removeItem(itemId) {
                    const row = document.querySelector(`tr[data-item-id="${itemId}"]`);
                    
                    fetch(`/cart/remove/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Animate row removal
                            row.style.opacity = '0';
                            row.style.transform = 'translateX(20px)';
                            
                            setTimeout(() => {
                                row.remove();
                                
                                // Update total
                                const totalElement = document.getElementById('cart-total-amount');
                                if (totalElement) {
                                    totalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.total);
                                }
                                
                                showAlert('Item removed successfully');

                                // Reload if cart is empty
                                if (data.itemCount === 0) {
                                    location.reload();
                                }
                            }, 300);
                        }
                    })
                    .catch(error => {
                        showAlert('Error removing item', 'danger');
                    });
                }

                // Quantity change handler
                document.querySelectorAll('.quantity-input').forEach(input => {
                    let timeoutId;
                    input.addEventListener('input', function() {
                        clearTimeout(timeoutId);
                        const itemId = this.dataset.itemId;
                        const quantity = parseInt(this.value);

                        timeoutId = setTimeout(() => {
                            if (quantity > 0) {
                                debouncedUpdateCart(itemId, quantity);
                            }
                        }, 500);
                    });
                });

                // Fix: Change the selector to match the button class in your HTML
                document.querySelectorAll('.remove-btn').forEach(button => {  // Changed from .remove-item to .remove-btn
                    button.addEventListener('click', function() {
                        showDeleteModal(this.dataset.itemId);
                    });
                });

                // Quantity buttons handlers
                document.querySelectorAll('.minus-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const itemId = this.dataset.itemId;
                        const input = document.querySelector(
                            `.quantity-input[data-item-id="${itemId}"]`);
                        const currentValue = parseInt(input.value);
                        if (currentValue > 1) {
                            input.value = currentValue - 1;
                            debouncedUpdateCart(itemId, currentValue - 1);
                        }
                    });
                });

                document.querySelectorAll('.plus-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const itemId = this.dataset.itemId;
                        const input = document.querySelector(
                            `.quantity-input[data-item-id="${itemId}"]`);
                        const currentValue = parseInt(input.value);
                        input.value = currentValue + 1;
                        debouncedUpdateCart(itemId, currentValue + 1);
                    });
                });

                // Prevent manual input of numbers
                document.querySelectorAll('.quantity-input').forEach(input => {
                    input.addEventListener('keydown', function(e) {
                        e.preventDefault();
                    });
                });

                // Modify existing quantity change handler
                document.querySelectorAll('.quantity-input').forEach(input => {
                    let timeoutId;
                    input.addEventListener('change', function() {
                        clearTimeout(timeoutId);
                        const itemId = this.dataset.itemId;
                        const quantity = parseInt(this.value);

                        timeoutId = setTimeout(() => {
                            if (quantity > 0) {
                                debouncedUpdateCart(itemId, quantity);
                            }
                        }, 500);
                    });
                });

                let itemToDelete = null;
                const deleteModal = document.getElementById('delete-modal');
                const modalContent = deleteModal.querySelector('.modal-content');

                function showDeleteModal(itemId) {
                    itemToDelete = itemId;
                    deleteModal.classList.remove('hidden');
                    setTimeout(() => {
                        deleteModal.querySelector('.modal-content').classList.remove('scale-95', 'opacity-0');
                    }, 10);
                }

                function closeDeleteModal() {
                    modalContent.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        deleteModal.classList.add('hidden');
                    }, 200);
                }

                // Update remove button click handler
                document.querySelectorAll('.remove-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        showDeleteModal(this.dataset.itemId);
                    });
                });

                // Add confirmation button handler
                document.getElementById('confirm-delete-btn').addEventListener('click', function() {
                    if (itemToDelete) {
                        const removeBtn = document.querySelector(`button[data-item-id="${itemToDelete}"]`);
                        removeBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Removing...';
                        removeBtn.disabled = true;

                        removeItem(itemToDelete);
                        closeDeleteModal();
                    }
                });

                // Close modal on backdrop click
                deleteModal.addEventListener('click', function(e) {
                    if (e.target === deleteModal) {
                        closeDeleteModal();
                    }
                });
            });
        </script>
    @endpush
@endsection

<style>
    /* Add these styles */
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('token');
    if (!token) {
        window.location.replace('/login');
        return;
    }

    // Add token to all fetch headers
    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`,
        'X-Auth-Token': token,
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    };

    // Update all fetch calls to use these headers
    const fetchOptions = {
        method: 'GET',
        headers: headers,
        credentials: 'include'
    };

    // Rest of your existing code using fetchOptions...
});
</script>
