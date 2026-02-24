@extends('layouts.default')
@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Checkout</h2>
        <p class="text-muted">Please fill in your details to complete the purchase</p>
    </div>

    <div class="row g-5">
        <div class="col-md-7 col-lg-8">
            <div class="card shadow-sm border-0 p-4">
                <h4 class="mb-4 fw-bold text-dark">Shipping Information</h4>

                <form action="{{ route('order.confirm') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label text-secondary fw-semibold">Full Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Enter your full name" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label text-secondary fw-semibold">Phone Number</label>
                            <input type="text" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" placeholder="+3 (___) ___-____" required>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="address" class="form-label text-secondary fw-semibold">Shipping Address</label>
                            <input type="text" name="address" id="address"
                                class="form-control @error('address') is-invalid @enderror"
                                value="{{ old('address') }}" placeholder="City, Street, House" required>
                        </div>

                        <hr class="my-4 text-muted">

                        <h4 class="mb-3 fw-bold text-dark text-center">Payment & Shipping</h4>

                        <div class="col-md-6">
                            <label for="shipping_method" class="form-label text-secondary fw-semibold">Carrier</label>
                            <select name="shipping_method" id="shipping_method" class="form-select bg-light border-0 shadow-sm">
                                <option value="Nova Poshta">Nova Poshta (Standard)</option>
                                <option value="Ukr Poshta">Ukr Poshta (Econom)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="payment_method" class="form-label text-secondary fw-semibold">Payment</label>
                            <select name="payment_method" id="payment_method" class="form-select bg-light border-0 shadow-sm">
                                <option value="Cash">Cash on Delivery</option>
                                <option value="Visa Card">Visa / MasterCard</option>
                            </select>
                        </div>
                    </div>

                    <button class="w-100 btn bg-primary btn-lg mt-5 fw-bold py-3 shadow" type="submit">
                        Complete Order
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-5 col-lg-4">
            <div class="card shadow-sm border-0 sticky-top overflow-hidden" style="top: 6rem;">
                <div class="card-header bg-primary text-white py-3 text-center">
                    <h5 class="mb-0 fw-bold text-dark">Order Summary</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($order->products as $product)
                        <li class="list-group-item py-3 px-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div style="max-width: 70%;">
                                    <h6 class="mb-0 fw-bold text-dark text-truncate" title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </h6>
                                    <small class="text-muted">
                                        {{ $product->pivot->count }} {{ Str::plural('unit', $product->pivot->count) }}
                                    </small>
                                </div>

                                <div class="text-end" style="white-space: nowrap; min-width: 80px;">
                                    <span class="fw-bold text-dark">
                                        {{ number_format($product->getCountPrice(), 2, '.', '') }} $
                                    </span>
                                </div>
                            </div>
                        </li>
                        @endforeach

                        <li class="list-group-item bg-light d-flex justify-content-between align-items-center py-4 px-4">
                            <span class="h5 mb-0 fw-bold">Total:</span>
                            <span class="h4 mb-0 fw-bold text-primary">{{ $order->getFullPrice() }} $</span>
                        </li>
                    </ul>

                    <div class="p-3 text-center">
                        <small class="text-muted d-block">
                            <i class="bi bi-shield-lock"></i> Secure Transaction
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection