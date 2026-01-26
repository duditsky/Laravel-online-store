@extends('layouts.default')

@section('title', 'Products List')

@section('content')
   
    <div class="d-flex justify-content-end mb-4">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Sort by
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('allProducts', ['sort_by' => 'name', 'sort_order' => 'asc'])}}">Name</a></li>
                <li><a class="dropdown-item" href="{{route('allProducts', ['sort_by' => 'price', 'sort_order' => 'asc'])}}">Price</a></li>
            </ul>
        </div>
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