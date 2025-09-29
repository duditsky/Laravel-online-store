@extends('layouts.default')

@section('title','All Posts')

@section('content')
<div class="starter-template" style="text-align: center;">
    <h1>Review</h1>
</div>

@foreach ($posts as $post)
<div class="container my-5">

    <div class="col-md-6">
        <h5>Product: {{$post->product->name}}</h5>
    </div>
    
    <h5 class="card-title"> Username: {{$post->user->name}}</h5>
     <div class="col-md-4">
            <a href="{{route('posts.edit',$post->id)}}" class="text-primary">Edit</a>
        </div>
    <div class="testimonial-card card">
        
        <div class="card-body">
            <p class="card-text">
            <h5>{{$post->text}}</h5>
            </p>

        </div>
    </div>
    
    
       
        <div class="col-md-4">
            <form action="{{route('posts.destroy',$post->id)}}" method="delete">
                @csrf
                <button class="btn btn-link link-danger" type="submit">Delete</button>
            </form>
        </div>
    
</div>
@endforeach
@endsection
<br>
<br>





