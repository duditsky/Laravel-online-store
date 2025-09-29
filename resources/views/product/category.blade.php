@extends('layouts.default') 
@section('title', 'Category')
@section('content')
<div class="container">
    <div class="row" style="text-align: center;">
        <h1>{{$category->name}}</h1>
        <p>{{$category->description}}</p>
      
            @foreach($category->products as $product)
                 <div class="col-md-3">
                  @include('product.card', ['product' => $product])
                </div>
            @endforeach
       
    </div>
</div>
@endsection