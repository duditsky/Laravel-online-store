@extends('layouts.default')
@section('title', 'Basket')
@section('content')
<div class="container">
    <div class="starter-template" style="text-align: center;">
        <h1>Basket</h1>
        <p>place an order</p>
        <div class="panel">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Full Price</th>
                    </tr>
                </thead>
            @foreach($order->products as $product)
                <tbody>
                    <tr>
                        <td>
                            <a href=" {{route('productDetails',[$product->category->code,$product->code])}}" class="card-link">
                                <img src="{{url('img/'.$product->image.'.jpg')}}" alt="" style="height: 50px; ">{{$product->name}}</a>
                        </td>
                        <td><span class="badge text-bg-secondary">{{$product->pivot->count}}</span>
                            <div class="btn-group">


                                <form action="{{route('basket.remove',[$product])}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">-
                                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                    </button>
                                </form>

                                <form action="{{route('basket.add',[$product])}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success">+
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </form>
                                </a>
                            </div>
                        </td>
                        <td>{{ $product->price }}$</td>
                        <td>{{ $product->getCountPrice()}}$</td>
                    </tr>
                  @endforeach

                    <tr>
                        <td colspan="3">Total:</td>
                        <td>{{$order->getFullPrice()}}$</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class="btn-group pull-right" role="group">
            <a type="button" class="btn btn-success" href="{{route('basket.place')}}">Buy It Now</a>
        </div>
    </div>
</div>
@endsection