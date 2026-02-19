@extends('layouts.default')

@section('title', 'Search Results')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-0">Search Results</h1>
            <p class="text-muted small">Found {{ $products->count() }} items for "{{ $search }}"</p>
        </div>

        @include('components.sort-dropdown')
    </div>

    @if($products->isEmpty())
    <div class="text-center py-5">
        <h3 class="text-muted">No products found</h3>
        <p>Try different keywords or browse all categories.</p>
        <a href="{{ route('allProducts') }}" class="btn btn-outline-dark rounded-pill">View all products</a>
    </div>
    @else
    <div class="row g-4 text-center">
        @foreach($products as $product)
        <div class="col-sm-6 col-md-4 col-lg-3">
            @include('product.card', ['product' => $product])
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection