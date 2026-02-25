@extends('layouts.default')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white p-3 mb-3">
                <div class="d-flex align-items-center">
                    <div class="h1 mb-0 me-3">📦</div>
                    <div>
                        <h6 class="mb-0">Total Orders</h6>
                        <h4 class="fw-bold mb-0">{{ $orders->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white p-3 mb-3">
                <div class="d-flex align-items-center">
                    <div class="h1 mb-0 me-3">💰</div>
                    <div>
                        <h6 class="mb-0">Total Spent</h6>
                        <h4 class="fw-bold mb-0">{{ number_format($orders->sum(fn($o) => $o->getFullPrice()), 2) }} USD</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-dark text-white p-3 mb-3">
                <div class="d-flex align-items-center">
                    <div class="h1 mb-0 me-3">💬</div>
                    <div>
                        <h6 class="mb-0">Your Reviews</h6>
                        <h4 class="fw-bold mb-0">{{ auth()->user()->posts->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mb-4 text-dark fw-bold">Recent Orders</h3>

    @forelse ($orders as $order)
        <div class="card shadow-sm mb-5 border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom p-3">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <span class="badge bg-light text-dark border mb-2">#{{ $order->id }}</span>
                        <h5 class="mb-0 fw-bold">Order from {{ $order->created_at->format('M d, Y') }}</h5>
                    </div>
                    <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                        @php
                            $statusRaw = $order->getRawOriginal('status');
                            $statusConfig = match($statusRaw) {
                                0 => ['class' => 'bg-secondary', 'percent' => 10],
                                1 => ['class' => 'bg-info', 'percent' => 40],
                                2 => ['class' => 'bg-warning', 'percent' => 70],
                                3 => ['class' => 'bg-success', 'percent' => 100],
                                4 => ['class' => 'bg-danger', 'percent' => 100],
                                default => ['class' => 'bg-dark', 'percent' => 0]
                            };
                        @endphp
                        <span class="badge {{ $statusConfig['class'] }} px-4 py-2 rounded-pill">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>
                
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar {{ $statusConfig['class'] }}" role="progressbar" 
                         style="width: {{ $statusConfig['percent'] }}%"></div>
                </div>
            </div>

            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($order->products as $product)
                        <li class="list-group-item p-4">
                            <div class="row align-items-center">
                                <div class="col-lg-5 d-flex align-items-center mb-3 mb-lg-0">
                                    <img src="{{ asset('storage/img/products/'.$product->image.'.jpg') }}" 
                                         class="rounded-3 shadow-sm me-3" 
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">{{ $product->name }}</h6>
                                        <span class="text-muted small">Qty: {{ $product->pivot->count }} items</span>
                                    </div>
                                </div>
                                
                                <div class="col-lg-7">
                                    @php
                                        $post = $order->posts ? $order->posts->where('product_id', $product->id)->first() : null;
                                        $canReview = $statusRaw == 3;
                                    @endphp

                                    @if($post)
                                        <div class="p-3 bg-light rounded-4 border-0 shadow-none position-relative">
                                            <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-success">
                                                ✓ Reviewed
                                            </span>
                                            <p class="mb-0 fst-italic small text-secondary">"{{ $post->text }}"</p>
                                        </div>
                                    @elseif($canReview)
                                        <form action="{{ route('posts.store') }}" method="POST" class="d-flex gap-2">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                            <input type="text" name="text" class="form-control form-control-sm border-0 bg-light" 
                                                   placeholder="How was the product?" required>
                                            <button class="btn btn-dark btn-sm rounded-3 px-3" type="submit">Post</button>
                                        </form>
                                    @else
                                        <div class="text-lg-end">
                                            <small class="text-muted"><i class="bi bi-clock"></i> Feedback available after delivery</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="card-footer bg-white border-top-0 p-3">
                <div class="row text-center text-md-start">
                    <div class="col-md-4 mb-2 mb-md-0">
                        <small class="text-muted d-block text-uppercase" style="font-size: 0.65rem;">Shipping Address</small>
                        <strong class="small">📍 {{ $order->address }}</strong>
                    </div>
                    <div class="col-md-4 mb-2 mb-md-0 border-start border-end">
                        <small class="text-muted d-block text-uppercase" style="font-size: 0.65rem;">Payment Method</small>
                        <strong class="small">💳 {{ $order->payment_method ?? 'Credit Card' }}</strong>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <small class="text-muted d-block text-uppercase" style="font-size: 0.65rem;">Total Amount</small>
                        <strong class="text-primary h5">{{ number_format($order->getFullPrice(), 2) }} USD</strong>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm text-center py-5 rounded-4">
            <div class="display-1 mb-3">🛒</div>
            <h4 class="text-muted">No orders yet</h4>
            <p>Looks like you haven't bought anything. Time to fix that!</p>
            <div class="mt-3">
                <a href="{{ route('home') }}" class="btn btn-primary px-5 rounded-pill">Explore Shop</a>
            </div>
        </div>
    @endforelse
</div>

@endsection