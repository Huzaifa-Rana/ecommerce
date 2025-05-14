@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payment Successful</h2>
    <p>Your payment was successful. Thank you for your order!</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Go back to Shop</a>
</div>
@endsection
