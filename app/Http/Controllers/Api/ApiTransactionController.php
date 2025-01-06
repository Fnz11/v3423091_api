<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class ApiTransactionController extends Controller
{
    public function index()
    {
        try {
            /** @var User $user */
            $user = auth()->user();
            
            $transactions = $user->role === User::ROLE_ADMIN
                ? Transaction::with(['user', 'items.clothes'])->latest()->get()
                : $user->transactions()->with('items.clothes')->latest()->get();

            return response()->json([
                'message' => 'Transactions retrieved successfully',
                'status' => 200,
                'data' => $transactions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving transactions',
                'status' => 500,
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'payment_method' => 'required|in:bank_transfer,e_wallet',
                'street' => 'required|string',
                'city' => 'required|string',
                'postal_code' => 'required|string',
            ]);

            $cart = Cart::where('user_id', auth()->id())->firstOrFail();

            if ($cart->items->isEmpty()) {
                return response()->json([
                    'message' => 'Cart is empty',
                    'status' => 422,
                    'data' => null
                ], 422);
            }

            // Restructure shipping address data
            $shippingAddress = [
                'street' => $validated['street'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code']
            ];

            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'total_amount' => $cart->total_amount,
                'payment_method' => $validated['payment_method'],
                'payment_token' => Transaction::generatePaymentToken(),
                'shipping_address' => $shippingAddress,
                'payment_due' => now()->addHours(Transaction::PAYMENT_DUE_HOURS),
                'status' => Transaction::STATUS_PENDING
            ]);

            foreach ($cart->items as $item) {
                $transaction->items()->create([
                    'clothes_id' => $item->clothes_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);
            }

            $cart->items()->delete();
            $cart->updateTotalAmount();

            return response()->json([
                'message' => 'Transaction created successfully',
                'status' => 201,
                'data' => $transaction->load('items.clothes')
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating transaction',
                'status' => 500,
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Transaction $transaction)
    {
        try {
            if (auth()->user()->role !== User::ROLE_ADMIN && $transaction->user_id !== auth()->id()) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'status' => 403,
                    'data' => null
                ], 403);
            }

            return response()->json([
                'message' => 'Transaction retrieved successfully',
                'status' => 200,
                'data' => $transaction->load('items.clothes', 'user')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving transaction',
                'status' => 500,
                'data' => null
            ], 500);
        }
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        try {
            if (auth()->user()->role !== User::ROLE_ADMIN) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'status' => 403,
                    'data' => null
                ], 403);
            }

            $validated = $request->validate([
                'status' => 'required|in:' . Transaction::STATUS_SUCCESS . ',' . Transaction::STATUS_FAILED,
            ]);

            $transaction->update(['status' => $validated['status']]);

            return response()->json([
                'message' => 'Transaction status updated successfully',
                'status' => 200,
                'data' => $transaction->fresh()
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating transaction status',
                'status' => 500,
                'data' => null
            ], 500);
        }
    }

    public function cancel(Transaction $transaction)
    {
        try {
            if ($transaction->user_id !== auth()->id()) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'status' => 403,
                    'data' => null
                ], 403);
            }

            if ($transaction->cancel()) {
                return response()->json([
                    'message' => 'Transaction cancelled successfully',
                    'status' => 200,
                    'data' => $transaction->fresh()
                ], 200);
            }

            return response()->json([
                'message' => 'Transaction cannot be cancelled',
                'status' => 422,
                'data' => null
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error cancelling transaction',
                'status' => 500,
                'data' => null
            ], 500);
        }
    }
}
