@extends('layouts.default')
@section('title', 'Shopping Cart')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            @if(!is_null($order) && $order->products->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
                <h4 class="lead text-primary fw-bold mb-0">Shopping Cart</h4>
                <h6 class="mb-0 text-muted">
                    <span id="total-items-count">{{ $order->products->sum('pivot.count') }}</span> items
                </h6>
            </div>
            <hr class="my-4">

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">Product</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->products as $product)
                            <tr id="row-{{ $product->id }}">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/img/products/' . $product->image . '.jpg') }}"
                                            class="rounded-3 me-3"
                                            style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                        <div>
                                            <a href="{{ route('productDetails', [$product->category->code, $product->code]) }}"
                                                class="text-dark fw-bold text-decoration-none d-block">
                                                {{ $product->name }}
                                            </a>
                                            <small class="text-muted small">Category: {{ $product->category->name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="btn-group shadow-sm rounded">
                                            <button type="button" class="btn btn-white btn-sm border px-3 cart-update-btn"
                                                data-url="{{ route('basket.remove', $product->id) }}"
                                                data-id="{{ $product->id }}">-</button>

                                            <span class="btn btn-white btn-sm border disabled fw-bold px-3" id="count-{{ $product->id }}">
                                                {{ $product->pivot->count }}
                                            </span>

                                            <button type="button" class="btn btn-white btn-sm border px-3 cart-update-btn"
                                                data-url="{{ route('basket.add', $product->id) }}"
                                                data-id="{{ $product->id }}">+</button>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center text-muted">${{ number_format($product->price, 2) }}</td>
                                <td class="text-center fw-bold text-dark">
                                    $<span id="item-price-{{ $product->id }}">{{ number_format($product->getCountPrice(), 2) }}</span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('basket.remove-all', $product->id) }}" method="POST" class="delete-all-form">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm border-0 rounded-circle">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white border-0 p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <a href="{{ route('home') }}" class="text-warning fw-bold text-decoration-none">
                                <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                            </a>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="mb-3">
                                <span class="text-muted me-2">Total Amount:</span>
                                <span class="h3 fw-bold">$<span id="total-amount">{{ number_format($order->getFullPrice(), 2) }}</span></span>
                            </div>
                            <a href="{{ route('order.place') }}" class="btn btn-warning btn-lg px-5 fw-bold shadow-sm rounded-3">
                                Buy It Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @else
            <div class="text-center py-5 mx-auto mt-5" style="max-width: 500px;">
                <i class="bi bi-cart-x text-muted" style="font-size: 5rem; opacity: 0.4;"></i>
                <h2 class="fw-bold text-dark mt-4">Your Basket is Empty!</h2>
                <p class="text-muted mb-4">Add items to start your creative journey with JoyStore. We have plenty of tech for you!</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-5 fw-bold shadow-sm" style="border-radius: 12px;">
                    Go Shopping
                </a>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection