@extends('layouts.default')

@section('title', 'Category: ' . $category->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold">Our Products</h1>
    @include('components.sort-dropdown')
</div>
<div class="container pt-3 pb-5">
    <div class="text-center mb-4">
        <h4 class="h2 fw-bold mb-2">{{ $category->name }}</h4>
        <p class="lead text-muted mb-3">{{ $category->description }}</p>
        <div class="mx-auto" style="width: 60px; height: 4px; background-color: #007bff; border-radius: 2px;"></div>
    </div>

    <div class="row g-4 justify-content-center">
        @forelse($category->products as $product)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">

            @include('product.card', ['product' => $product])
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <h3 class="text-muted">No products found in this category.</h3>
            <a href="/" class="btn btn-primary mt-3">Continue Shopping</a>
        </div>
        @endforelse
    </div>
</div>
@endsection