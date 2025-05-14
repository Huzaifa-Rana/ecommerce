<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Get all items in the session cart
        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
        if (!$product) {
            return redirect()->route('home')->with('error', 'Product not found');
        }

        // Get cart from session or initialize an empty array
        $cart = session()->get('cart', []);

        // Add product to cart
        $cart[$product->id] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => isset($cart[$product->id]) ? $cart[$product->id]['quantity'] + 1 : 1,
            'image' => $product->image,
        ];

        // Save cart back to session
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart');
    }

    public function removeFromCart($productId)
    {
        // Remove product from cart
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart');
    }
}
