<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
    {
        // Fetch all orders and pass them to the view
        $orders = Order::with('user')->get();
        return view('admin.orders.index', compact('orders'));
    }
}
