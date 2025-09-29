@extends('layouts.default')
@section('title', 'Product Details')
@section('content')
<div class="container">
    <div class="starter-template" style="text-align: center;">
        <h1>{{$product->name}}</h1>
        <img src="{{url('img/'.$product->image.'.jpg')}}" alt="" height="400px">
        <p>{{$product->description}}</p>
        <p>Price: ${{$product->price}}</p>
        <form action="{{route('basket.add', $product)}}" method="POST">
             <button type="submit" class="btn btn-success">To Cart</button>
             @csrf
         </form>
    </div>
</div>
<div class="container">
    <h1>Review:</h1>

    <div class="row">
        <div class="col-sm-6 col-md-8">
            @foreach($product->posts as $post)
            <div class="testimonial-card card">
                <div class="card-body">
                       <p class="testimonial-author">{{$post->user->name}}:</p>
                    <p class="testimonial-text">
                      <h3>{{ $post->text}}</h3>  
                    </p>
                 
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection