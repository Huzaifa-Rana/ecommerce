<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Ensure user is authenticated
        $this->middleware('auth');
    }

    public function index()
    {
        // Check user role and redirect accordingly
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard'); // Adjust route if needed
        }

        // Get the cart from session
        $cart = session()->get('cart', []);
        $totalAmount = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('checkout.index', compact('cart', 'totalAmount'));
    }

    public function processCheckout(Request $request)
    {
        // Get the cart and total amount
        $cart = session()->get('cart', []);
        $totalAmount = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Create Stripe payment session
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkoutSession = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => collect($cart)->map(function ($item) {
                return [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item['name'],
                        ],
                        'unit_amount' => $item['price'] * 100,
                    ],
                    'quantity' => $item['quantity'],
                ];
            })->toArray(),
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['order_id' => 'ORDER_ID']),
            'cancel_url' => route('checkout.index'),
        ]);

        // Create the order record if payment is successful
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
            'status' => 'pending', // Update based on your flow
        ]);

        // Add items to the order
        foreach ($cart as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'product_name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
            ]);
        }

        // Clear the cart
        session()->forget('cart');

        return redirect($checkoutSession->url);
    }

    public function success()
    {
        // Handle successful payment here (store order, etc.)
        session()->forget('cart');
        return view('checkout.success');
    }
}
