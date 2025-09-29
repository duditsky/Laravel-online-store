@extends('layouts.default')
@section('title', 'Search Results')
@section('content')
<div class="container">
    <h1>Search Results for: {{$search}}</h1>
    <div class="row" style="text-align: center;">
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card">
                    <img src="{{url('img/'.$product->image.'.jpg')}}" class="card-img-top" alt="{{$product->name}}">
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">Price: ${{$product->price}}</p>
                        <a href="{{route('productDetails',[$product->category->code,$product->code])}}" class="btn btn-primary">View Details</a>
                         <a href="{{route('basket')}}" class="btn btn-primary" role="button">To Cart</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection