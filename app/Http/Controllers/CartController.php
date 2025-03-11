<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{

    public function AddToCart(Request $request)
    {
        try {
            // Fixing validation rules
            $request->validate([
                'product_id' => "required|exists:products,id",
                'quantity' => "required|integer|min:1"
            ]);

            $cart = Auth::user()->cart;

            // Ensure the cart exists
            if (!$cart) {
                return response()->json(['status' => false, 'message' => 'Cart not found'], 404);
            }

            $product = Product::findOrFail($request->product_id);

            // Check if the product is already in the cart
            $cartItem = $cart->items()->where('product_id', $request->product_id)->first();

            if (!$cartItem) {
                // If the product is not in the cart, add a new entry
                $cart->items()->attach($request->product_id, [
                    'price' => $product->price * $request->quantity,
                    'quantity' => $request->quantity,
                ]);
            } else {
                // If the product already exists in the cart, update the quantity & price
                $cart->items()->updateExistingPivot($request->product_id, [
                    'price' => $product->price * $request->quantity,
                    'quantity' => $request->quantity,
                ]);
            }

            return response()->json(['status' => true, 'message' => $product->name . " added successfully"]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }



    public function deleteItem($id)
    {
        try {
            $cart = Auth::user()->cart;
            CartItems::where('id',$id)->delete();
            return response()->json(['status' => true, 'message' => "Item Deleted successfully"]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function viewCart()
    {
        $cart = Auth::user()->cart;

        return view('user.carts.index', compact('cart'));
    }
}
