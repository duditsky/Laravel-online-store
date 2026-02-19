@extends('layouts.default')


@section('title', 'Home Page')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold">Our Products</h1>
    @include('components.sort-dropdown')
</div>
<div class="container">
    <div class="row" style="text-align: center;">
        @foreach($products as $product)
        <div class="col-md-4">
            @include('product.card', ['product' => $product])
        </div>
        @endforeach
    </div>
</div>
@endsection