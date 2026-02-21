@extends('layouts.default')

@section('title', 'Category: ' . $category->name)

@section('content')
<div class="container pt-3 pb-5">
    <div class="text-center mb-4 mt-5"> <p class="lead text-primary fw-bold mb-3">{{ $category->description }}</p>
    @include('components.sort-dropdown')
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