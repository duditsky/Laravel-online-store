@extends('layouts.default')

@section('title', 'Products List')

@section('content')

<div class="row text-center">
    <div class="container pt-3 pb-5">
    <div class="text-center mb-4 mt-5"> 
        <h1 class="admin-title">All Products</h1>
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