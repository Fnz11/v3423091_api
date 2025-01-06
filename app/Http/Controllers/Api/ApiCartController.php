<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Clothes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiCartController extends Controller
{
    public function index()
    {
        try {
            $cart = Cart::with('items.clothes')->firstOrCreate(['user_id' => auth()->id()]);

            return response()->json([
                'message' => 'Cart retrieved successfully',
                'status' => 200,
                'data' => $cart
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving cart',
                'status' => 500,
                'data' => null
            ], 500);
        }
    }

    public function addToCart(Request $request, Clothes $clothes)
    {
        try {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
            $quantity = $request->input('quantity', 1);

            if ($quantity > $clothes->stock) {
                return response()->json([
                    'message' => 'Requested quantity exceeds available stock',
                    'status' => 422,
                    'data' => null
                ], 422);
            }

            $cartItem = $cart->items()->where('clothes_id', $clothes->id)->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $quantity);
                $cartItem->update(['subtotal' => $cartItem->price * $cartItem->quantity]);
            } else {
                $cartItem = $cart->items()->create([
                    'clothes_id' => $clothes->id,
                    'quantity' => $quantity,
                    'price' => $clothes->price,
                    'subtotal' => $clothes->price * $quantity
                ]);
            }

            $cart->updateTotalAmount();

            return response()->json([
                'message' => 'Item added to cart successfully',
                'status' => 200,
                'data' => $cart->load('items.clothes')
            ], 200);
        } catch (\Exception $e) {
            Log::error('Cart Add Error:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to add item to cart',
                'status' => 500,
                'data' => null
            ], 500);
        }
    }

    public function updateQuantity(Request $request, $id)
    {
        try {
            Log::info('Attempting to update cart item', [
                'cart_item_id' => $id,
                'user_id' => auth()->id()
            ]);

            // First check if the cart item exists without the owner check
            $POPO = CartItem::get();
            $cartItemExists = CartItem::find(id: $id);
            if (!$cartItemExists) {
                Log::warning('Cart item not found', ['id' => $id]);
                return response()->json([
                    'message' => 'Cart item not found',
                    'status' => 404,
                    'data' => $POPO[0],
                    'id' => $id
                ], 404);
            }

            // Then check with owner validation
            $cartItem = CartItem::where('id', $id)
                ->whereHas('cart', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->first();

            if (!$cartItem) {
                Log::warning('Cart item not found for user', [
                    'id' => $id,
                    'user_id' => auth()->id()
                ]);
                return response()->json([
                    'message' => 'Cart item not found',
                    'status' => 404,
                    'data' => null
                ], 404);
            }

            Log::info('Updating cart item', [
                'cart_item_id' => $cartItem->id,
                'user_id' => auth()->id(),
                'request' => $request->all()
            ]);

            // Verify ownership
            if ($cartItem->cart->user_id !== auth()->id()) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'status' => 403,
                    'data' => null
                ], 403);
            }

            $request->validate(['quantity' => 'required|integer|min:1']);

            if ($request->quantity > $cartItem->clothes->stock) {
                return response()->json([
                    'message' => 'Requested quantity exceeds available stock',
                    'status' => 422,
                    'data' => null
                ], 422);
            }

            $cartItem->update([
                'quantity' => $request->quantity,
                'subtotal' => $cartItem->price * $request->quantity
            ]);

            $cartItem->cart->updateTotalAmount();
            $cart = $cartItem->cart->load('items.clothes');

            return response()->json([
                'message' => 'Cart quantity updated successfully',
                'status' => 200,
                'data' => [
                    'cart' => $cart,
                    'subtotal' => $cartItem->subtotal,
                    'total' => $cart->total_amount
                ]
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Cart item not found',
                'status' => 404,
                'data' => null
            ], 404);
        } catch (\Exception $e) {
            Log::error('Cart update error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'cart_item_id' => $id,
                'user_id' => auth()->id()
            ]);
            return response()->json([
                'message' => 'Error updating cart item',
                'status' => 500,
                'data' => null
            ], 500);
        }
    }

    public function removeItem($id)
    {
        try {
            $cartItem = CartItem::where('id', $id)
                ->whereHas('cart', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->firstOrFail();

            $cart = $cartItem->cart;
            $cartItem->delete();
            $cart->updateTotalAmount();
            $cart->load('items.clothes');

            return response()->json([
                'message' => 'Item removed successfully',
                'status' => 200,
                'data' => [
                    'cart' => $cart,
                    'total' => $cart->total_amount,
                    'itemCount' => $cart->items->count()
                ]
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Cart item not found',
                'status' => 404,
                'data' => null
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error removing item',
                'status' => 500,
                'data' => null
            ], 500);
        }
    }
}
