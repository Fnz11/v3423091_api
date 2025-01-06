<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    public function index()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $transactions = $user->role === User::ROLE_ADMIN
                ? Transaction::with(['user', 'items.clothes'])->latest()->get()
                : $user->transactions()->with('items.clothes')->latest()->get();

            return view('transactions.index', compact('transactions'));
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Please login to view transactions');
        }
    }

    public function checkout()
    {
        $cart = Cart::where('user_id', auth()->id())->firstOrFail();
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        return view('transactions.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $request->validate([
                'payment_method' => 'required|in:bank_transfer,e_wallet',
                'shipping_address' => 'required|array',
                'shipping_address.street' => 'required|string',
                'shipping_address.city' => 'required|string',
                'shipping_address.postal_code' => 'required|string',
            ]);

            $cart = Cart::where('user_id', $user->id)->firstOrFail();

            // Check stock availability
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->clothes->stock) {
                    return back()->with('error', "Not enough stock for {$item->clothes->name}");
                }
            }

            // Create transaction with payment token
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'total_amount' => $cart->total_amount,
                'payment_method' => $request->payment_method,
                'payment_token' => Transaction::generatePaymentToken(),
                'shipping_address' => $request->shipping_address,
                'payment_due' => now()->addHours(Transaction::PAYMENT_DUE_HOURS),
                'status' => Transaction::STATUS_PENDING
            ]);

            // Create transaction items and reduce stock
            foreach ($cart->items as $item) {
                $transaction->items()->create([
                    'clothes_id' => $item->clothes_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);

                // Reduce stock
                $item->clothes->decrement('stock', $item->quantity);
            }

            // Clear cart
            $cart->items()->delete();
            $cart->updateTotalAmount();

            return redirect()->route('user.transactions.show', $transaction);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order'
            ], 500);
        }
    }

    public function show(Transaction $transaction)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if ($user->role !== User::ROLE_ADMIN && $transaction->user_id !== $user->id) {
                abort(403);
            }

            return view('transactions.show', compact('transaction'));
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Please login to view transaction');
        }
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        if (auth()->user()->role !== User::ROLE_ADMIN) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:' . Transaction::STATUS_SUCCESS . ',' . Transaction::STATUS_FAILED,
        ]);

        $transaction->update(['status' => $request->status]);

        return back()->with('success', 'Transaction status updated');
    }

    public function cancel(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        if ($transaction->cancel()) {
            // Stock restoration is handled by the Transaction model's updating event
            return back()->with('success', 'Transaction cancelled successfully');
        }

        return back()->with('error', 'Transaction cannot be cancelled');
    }
}
