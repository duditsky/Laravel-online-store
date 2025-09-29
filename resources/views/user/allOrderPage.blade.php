@extends('layouts.default')

@section('title','All Orders')

@section('content')


<body>
    <div class="container my-5">
        <div class="starter-template" style="text-align: center;">
            <h1>Users Orders</h1>

        </div>
        <ul>
            @foreach ($users as $user)
            <h3>
                <li> {{ $user->name}}</li>
            </h3>
            @foreach ($user->orders as $order)
            
                <h4>Order number: {{ $order->id }}, Date: {{ $order->created_at }}, Status: {{ $order->status }}</h4>
           
        
            @foreach($order->products as $product)
            <li> {{ $product->name}}</li>
             @endforeach
              
            <br>
            <div>
                
                <form method="POST" action="{{ route('status.orders', $order->id) }}">
                    @csrf
                    @method('PUT')
                    <select name="status" id="status" class="form-select" style="width:150px" aria-label="Default select example">
                        <option selected>Order Status:</option>
                        <option value="1" {{ $order->status == 1 ? 'selected' : 'pending' }}>pending</option>
                        <option value="2" {{ $order->status == 2 ? 'selected' : 'shipped' }}>shipped</option>
                        <option value="3" {{ $order->status == 3 ? 'selected' : 'completed' }}>completed</option>
                        <option value="4" {{ $order->status == 4 ? 'selected' : 'cancelled' }}>cancelled</option>
                    </select>
                    <button type="submit" class="btn btn-success">Change Status</button>
                </form>
            </div>
            <br>
            <br>
            <br>
       
            @endforeach
        


        @endforeach

    </div>
</body>
 </ul>
</html>
@endsection