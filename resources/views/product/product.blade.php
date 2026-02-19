@extends('layouts.default')

@section('title', 'Products List')

@section('content')

<div class="row text-center">
    <h4>All Products</h4>   @include('components.sort-dropdown')
    <div class="row mt-4">
        @foreach($products as $product)
        <div class="col-md-3 mb-4">
            @include('product.card', ['product' => $product])
        </div>
        @endforeach
    </div>
</div>
@endsection