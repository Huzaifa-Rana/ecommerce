@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Product</h2>

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

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Product Name *</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price *</label>
            <input type="number" class="form-control" id="price" name="price" required step="0.01" value="{{ old('price') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image (optional)</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Create Product</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
