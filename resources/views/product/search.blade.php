@extends('layouts.default')

@section('title', 'Search Results')

@section('content')
<div class="container pt-3 pb-5">

    @if($products->isEmpty())
    <div class="text-center py-5">
        <h3 class="text-muted">No products found</h3>
        <p>Try different keywords or browse all categories.</p>
        <a href="{{ route('allProducts') }}" class="btn btn-outline-dark rounded-pill">View all products</a>
    </div>
    @else
    
    <div class="row g-4 text-center">
        <div class="text-center mb-2" style="margin-top: 100px; padding-bottom: 10px;">
    <h1 class="text-primary fw-bold mb-2" style="font-size: 2.2rem; letter-spacing: -0.5px;">
        Search results for "<span class="text-danger">{{ $search }}</span>"
    </h1>

    <div class="d-flex justify-content-center mt-3">
        @include('components.sort-dropdown')
    </div>
</div>

        @foreach($products as $product)
        <div class="col-sm-6 col-md-4 col-lg-3">
            @include('product.card', ['product' => $product])
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection