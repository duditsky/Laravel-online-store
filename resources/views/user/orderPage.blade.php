@extends('layouts.default')

@section('title','User Order')

@section('content')


<body>
    <div class="container my-5">
        <div class="starter-template" style="text-align: center;">
            <h1>Your Orders</h1>
           </div>
      <br>
 <br>
            @foreach ($orders as $order)
                
                 
           
                <h4>Order number: {{ $order->id }}, Date: {{ $order->created_at }}, Status: {{ $order->status }}</h4>
            <br>
        @foreach($order->products as $product)  
             {{ $product->name}}
        @php
        $post = $order->posts->where('product_id', $product->id)->first();
        @endphp
    <br>
 
            @if(!$post)
              
         <form action="{{route('posts.store')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="text" class="form-label"></label>
                    <input type="text" name="text" class="form-control" id="text" placeholder="Review">

                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="user_id" value="{{ $order->user->id }}">
                </div>
                <button type="submit" class="btn btn-success">Send</button>
            </form>
       
            @else
         
              <div class="testimonial-card card">
            
            
                <div class="card-body">
            <p>{{ $post->text }}</p>
           </div>
            </div>
            @endif
          
<br>

    
      @endforeach


    
        @endforeach

     </div>
</body>


@endsection