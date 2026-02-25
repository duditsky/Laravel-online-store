@extends('layouts.default')

@section('title','All Posts')

@section('content')

<body>
    <div class="container my-5">
        <div class="starter-template" style="text-align: center;">
            <h1>All Posts</h1>

        </div>
        <ul>
            @foreach ($users as $user)
            <h3>
                <li> {{ $user->name}}</li>
            </h3>


            @foreach($order->products as $product)
            <li> {{ $product->name}}</li>
            <p>{{$order->user->name}}:</p>
            @foreach($product->posts as $post)
            <div class="testimonial-card card">
                <div class="card-body">
                    <p>{{ $post->text }}</p>
                </div>
            </div>
            @endforeach
            <br>
    </div>
  
    @endforeach
    </ul>
    @endforeach
</body>


@endsection