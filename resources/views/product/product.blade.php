@extends('layouts.default')

@section('title', 'Products List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold">Our Products</h1>
    @include('components.sort-dropdown')
</div>
<div class="row text-center">
    <h1>All Products</h1>
    <div class="row mt-4">
        @foreach($products as $product)
        <div class="col-md-3 mb-4">
            @include('product.card', ['product' => $product])
        </div>
        @endforeach
    </div>
</div>
@endsection