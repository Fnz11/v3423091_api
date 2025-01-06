<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Clothes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class CartController extends Controller
{
    public function __construct()
    {
        // Remove the middleware from here since it's now handled in routes
        // $this->middleware('jwt.verify');
    }

    public function index()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
            return view('cart.index', compact('cart'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized', 'redirect' => '/login'], 401);
        }
    }

    public function addToCart(Request $request, Clothes $clothes)
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        
        $quantity = $request->input('quantity', 1);
        
        $cartItem = $cart->items()->where('clothes_id', $clothes->id)->first();
        
        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
            $cartItem->update(['subtotal' => $cartItem->price * $cartItem->quantity]);
        } else {
            $cart->items()->create([
                'clothes_id' => $clothes->id,
                'quantity' => $quantity,
                'price' => $clothes->price,
                'subtotal' => $clothes->price * $quantity
            ]);
        }

        $cart->updateTotalAmount();

        return redirect()->route('cart.index')->with('success', 'Item added to cart successfully!');
    }

    public function updateQuantity(Request $request, CartItem $cartItem)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            if ($cartItem->cart->user_id !== $user->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $request->validate(['quantity' => 'required|integer|min:1']);
        
            if ($request->quantity > $cartItem->clothes->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requested quantity exceeds available stock'
                ], 422);
            }

            $cartItem->update([
                'quantity' => $request->quantity,
                'subtotal' => $cartItem->price * $request->quantity
            ]);

            $cartItem->cart->updateTotalAmount();

            return response()->json([
                'success' => true,
                'subtotal' => $cartItem->subtotal,
                'total' => $cartItem->cart->total_amount
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Update failed'], 500);
        }
    }

    public function removeItem(CartItem $cartItem)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            if ($cartItem->cart->user_id !== $user->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $cart = $cartItem->cart;
            $cartItem->delete();
            $cart->updateTotalAmount();

            return response()->json([
                'success' => true,
                'total' => $cart->total_amount,
                'itemCount' => $cart->items->count()
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Remove failed'], 500);
        }
    }

    public function add(Request $request, $id)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            $cloth = Clothes::findOrFail($id);
            $quantity = max(1, intval($request->input('quantity', 1)));

            if ($quantity > $cloth->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requested quantity exceeds available stock'
                ], 422);
            }

            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
            
            $cartItem = $cart->items()->updateOrCreate(
                ['clothes_id' => $cloth->id],
                [
                    'quantity' => $quantity,
                    'price' => $cloth->price,
                    'subtotal' => $cloth->price * $quantity
                ]
            );

            $cart->updateTotalAmount();

            Log::debug('Cart Add Success:', ['cart_item' => $cartItem->id]);

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully',
                'cartCount' => $cart->items->sum('quantity')
            ]);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token invalid'], 401);
        } catch (\Exception $e) {
            Log::error('Cart Add Error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to add item to cart'
            ], 500);
        }
    }
}
