@extends('layouts.default')

@section('title', 'Products List')

@section('content')

<div class="row text-center">
    <div class="container pt-3 pb-5">
    <div class="text-center mb-4 mt-5"> <p class="lead text-primary fw-bold mb-3">All Products</p>
    @include('components.sort-dropdown')
</div>

    <div class="row mt-4">
        @foreach($products as $product)
        <div class="col-md-3 mb-4">
            @include('product.card', ['product' => $product])
        </div>
        @endforeach
    </div>
</div>
@endsection