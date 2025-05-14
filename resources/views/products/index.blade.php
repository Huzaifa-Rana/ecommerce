@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>All Products</h2>
    
    @if($products->isEmpty())
        <p>No products available at the moment.</p>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ $product->name }}</h5>
                            <p>${{ $product->price }}</p>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button class="btn btn-sm btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
