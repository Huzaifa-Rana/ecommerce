@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admin Products</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">Add New Product</a>
    @foreach ($products as $product)
        <div class="card mb-2">
            <div class="card-body">
                <h5>{{ $product->name }} - ${{ $product->price }}</h5>
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
