@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following issues:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Product Name *</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $product->name) }}">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price *</label>
            <input type="number" class="form-control" id="price" name="price" required step="0.01" value="{{ old('price', $product->price) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="150" class="mb-2">
            @else
                <p><em>No image uploaded</em></p>
            @endif
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Replace Image (optional)</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
