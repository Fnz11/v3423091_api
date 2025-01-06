<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $transactions = Transaction::with(['user', 'items.clothes'])->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:' . Transaction::STATUS_SUCCESS . ',' . Transaction::STATUS_FAILED,
        ]);

        $oldStatus = $transaction->status;
        $newStatus = $request->status;

        $transaction->update(['status' => $newStatus]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaction status updated successfully'
            ]);
        }
        
        return back()->with('success', 'Transaction status updated successfully');
    }
}
