@extends('layouts.default')


@section('title', 'Home Page')
@section('content')
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