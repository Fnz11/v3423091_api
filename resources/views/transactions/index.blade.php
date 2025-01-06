@extends('layouts.admin')

@section('title', 'Transactions')
@section('page-title', 'Transactions')

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
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-4xl font-bold mb-8 text-gray-800 tracking-tight">My Transactions</h1>

        <div class="backdrop-blur-lg bg-white/70 rounded-3xl content-container p-5 animate-scaleIn">
            <div class="flex justify-between items-center mb-6">
                <div class="flex gap-4">
                    <select id="status-filter"
                        class="bg-white/90 rounded-xl px-4 py-2 border-none shadow-sm font-medium text-gray-600">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="success">Success</option>
                        <option value="failed">Failed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="scrollbar-hide">
                <table class="w-full border-separate border-spacing-y-4">
                    <thead>
                        <tr class="text-left text-gray-600">
                            <th class="px-6 py-4">ID</th>
                            @if (auth()->user()->isAdmin())
                                <th class="px-6 py-4">Customer</th>
                            @endif
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Payment Due</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr
                                class="bg-white/90 rounded-2xl transition-all duration-300 hover:translate-y-[-5px] hover:scale-[1.01] hover:shadow-lg animate-fadeIn">
                                <td class="px-6 py-4 font-semibold text-gray-800">#{{ $transaction->id }}</td>
                                @if (auth()->user()->isAdmin())
                                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $transaction->user->name }}</td>
                                @endif
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    Rp {{ number_format($transaction->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4">
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
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    {{ $transaction->payment_due->format('M d, Y H:i') }}
                                    @if ($transaction->status === 'pending' && $transaction->isExpired())
                                        <span class="text-red-600 ml-2 font-medium">(Expired)</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('user.transactions.show', $transaction) }}"
                                            class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-xl font-medium transition-all duration-300 hover:translate-y-[-2px] hover:shadow-lg inline-flex items-center gap-2">
                                            <i class="fas fa-eye"></i>
                                            View
                                        </a>
                                        @if (auth()->user()->isAdmin() && $transaction->status === 'pending')
                                            <form action="{{ route('admin.transactions.update-status', $transaction) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="success">
                                                <button type="submit"
                                                    class="px-3 py-1 bg-green-100 text-green-600 rounded-lg">
                                                    Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.transactions.update-status', $transaction) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="failed">
                                                <button type="submit" class="px-3 py-1 bg-red-100 text-red-600 rounded-lg">
                                                    Reject
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
