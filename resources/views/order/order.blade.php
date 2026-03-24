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
                                value="{{ old('phone') }}" placeholder="+38 (___) ___-____" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="address" class="form-label text-secondary fw-semibold">Home Address (Optional)</label>
                            <input type="text" name="address" id="address"
                                class="form-control" value="{{ old('address') }}" placeholder="Street, House, Apt">
                        </div>

                        <hr class="my-4 text-muted">
                        <h4 class="mb-3 fw-bold text-dark text-center">Payment & Shipping</h4>

                        <div class="col-md-6">
                            <label for="shipping_method" class="form-label text-secondary fw-semibold">Carrier</label>
                            <select name="shipping_method" id="shipping_method" class="form-select bg-light border-0 shadow-sm">
                                <option value="Ukr Poshta">Ukr Poshta (Econom)</option>
                                <option value="Nova Poshta">Nova Poshta (Standard)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="payment_method" class="form-label text-secondary fw-semibold">Payment</label>
                            <select name="payment_method" id="payment_method" class="form-select bg-light border-0 shadow-sm">
                                <option value="cash">Cash on Delivery</option>
                                <option value="liqpay">Visa / MasterCard (LiqPay)</option>
                            </select>
                        </div>

                        <div id="nova-poshta-fields" class="d-none col-12 mt-4">
                            <div class="p-3 border rounded bg-light shadow-sm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="city-select" class="form-label text-secondary fw-semibold">City</label>
                                        <select name="city_name" id="city-select" class="form-select" style="width: 100%;">
                                            <option value="">Search for a city</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="warehouse-select" class="form-label text-secondary fw-semibold">Warehouse</label>
                                        <select name="warehouse_name" id="warehouse-select" class="form-select" style="width: 100%;" disabled>
                                            <option value="">Select city first</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="w-100 btn btn-primary btn-lg mt-5 fw-bold py-3 shadow" type="submit">
                        Complete Order
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-5 col-lg-4">
            <div class="card shadow-sm border-0 sticky-top overflow-hidden" style="top: 2rem;">
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
                                    <small class="text-muted">{{ $product->pivot->count }} units</small>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold text-dark">{{ number_format($product->getCountPrice(), 2, '.', '') }} $</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                        <li class="list-group-item bg-light d-flex justify-content-between align-items-center py-4 px-4">
                            <span class="h5 mb-0 fw-bold">Total:</span>
                            <span class="h4 mb-0 fw-bold text-primary">{{ $order->getFullPrice() }} $</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/novaposhta.js') }}"></script>
@endpush
@endsection