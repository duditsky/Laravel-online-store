@extends('layouts.default')
@section('title', 'order')
@section('content')

<div class="starter-template">
    <h1>Place your order</h1>
    <div class="container">
        <div class="row justify-container-center">
            <p>Total price: <b>{{$order->getFullPrice()}} $</b></p>
            <form action="{{route('basket.confirm')}}" method="post">

                <div>
                    <p>Input your details:</p>
                    <div class="container">
                        <div class="form-group">
                            <label for="name" class="control-label col-lg-offset-3 col-lg-2">Name</label>
                            <div class="col-lg-4">
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>

                        <br>
                        <div class="form-group">
                            <label for="phone" class="control-label col-lg-offset-3 col-lg-2">Phone</label>
                            <div class="col-lg-4">
                                <input type="text" name="phone" id="phone" class="form-control">
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="address" class="control-label col-lg-offset-3 col-lg-2">Address</label>
                            <div class="col-lg-4">
                                <input type="text" name="address" id="address" class="form-control">
                            </div>
                        </div>
                        <br>
                        <br>
                        <div>
                            <select name="shipping_method" class="form-select" style="width:425px" aria-label="Default select example">
                                <option selected>Shipping method</option>
                                <option value="Nova Poshta">Nova Poshta</option>
                                <option value="Ukr Poshta">Ukr Poshta</option>
                            </select>
                        </div>
                        <br>
                        <br>
                        <div>
                            <select name="payment_method" id="payment_method" class="form-select" style="width:425px" aria-label="Default select example">
                                <option selected>Payment method</option>
                                <option value="Cash">Cash</option>
                                <option value="Visa Card">Visa Card</option>
                                <option value="Master Card">Master Card</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <br>

                    @csrf
                    <input type="submit" class="btn btn-success" value="Place order">
                </div>
            </form>
        </div>
    </div>
</div>

@endsection