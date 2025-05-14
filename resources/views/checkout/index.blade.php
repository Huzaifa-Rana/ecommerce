@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Checkout</h2>
    @if(session('cart'))
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach (session('cart') as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Total: ${{ number_format(collect(session('cart'))->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        }), 2) }}</h3>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Proceed to Payment</button>
        </form>
    @else
        <p>Your cart is empty. Please add some products.</p>
    @endif
</div>
@endsection
