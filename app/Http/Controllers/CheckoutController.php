<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    public function index()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $cart = Cart::where('user_id', $user->id)->firstOrFail();
            
            if ($cart->items->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty');
            }
            
            return view('transactions.checkout', compact('cart'));
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Please login to continue');
        }
    }

    public function store(Request $request)
    {
        // Redirect to TransactionController store method
        return app(TransactionController::class)->store($request);
    }
}
