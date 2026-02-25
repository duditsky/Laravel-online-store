@extends('layouts.default')

@section('title', 'Admin Panel - Orders Management')

@section('content')
<div class="admin-container container py-5">
    
    <div class="admin-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="admin-title">Orders Management</h1>
            <p class="admin-subtitle text-muted">Manage customer orders and tracking statuses</p>
        </div>
        <div class="admin-stats-badge">
            <span class="badge">Total Users: {{ $users->count() }}</span>
        </div>
    </div>

    <div class="row g-3 mb-5 text-center">
       @php $allOrders = $users->getCollection()->flatMap->orders; @endphp
        <div class="col-6 col-md-3">
            <div class="stat-card shadow-sm">
                <small class="stat-label">Total Orders</small>
                <span class="stat-value">{{ $allOrders->count() }}</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card shadow-sm border-success-subtle">
                <small class="stat-label text-success">Completed</small>
                <span class="stat-value">{{ $allOrders->where('status', 'Completed')->count() }}</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card shadow-sm border-warning-subtle highlight-warning">
                <small class="stat-label text-warning">In Progress</small>
                <span class="stat-value">{{ $allOrders->whereIn('status', ['Pending', 'Shipped', 'New'])->count() }}</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card shadow-sm">
                <small class="stat-label">Total Revenue</small>
                <span class="stat-value text-primary">${{ number_format($allOrders->sum(fn($o) => $o->getFullPrice()), 2) }}</span>
            </div>
        </div>
    </div>

    @foreach ($users as $user)
        <div class="admin-user-card shadow-sm mb-5">
            <div class="admin-card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-person"></i> {{ $user->name }}</h5>
                <span class="small opacity-75">Customer ID: #{{ $user->id }}</span>
            </div>
            
            <div class="table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Products</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-end">Management</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->orders as $order)
                        <tr>
                            <td class="order-id">
                                <strong>#{{ $order->id }}</strong>
                                <div class="order-date">{{ $order->created_at->format('d M, H:i') }}</div>
                            </td>
                            <td class="order-products">
                                @foreach($order->products as $product)
                                    <span class="product-tag">{{ $product->name }} (x{{ $product->pivot->count }})</span>
                                @endforeach
                            </td>
                            <td class="order-price">
                                <strong>${{ number_format($order->getFullPrice(), 2) }}</strong>
                            </td>
                            <td>
                                @php
                                    $statusRaw = $order->getRawOriginal('status');
                                    $statusClass = match($statusRaw) {
                                        0 => 'st-new', 1 => 'st-pending', 2 => 'st-shipped',
                                        3 => 'st-completed', 4 => 'st-cancelled', default => 'st-dark'
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('status.orders', $order->id) }}" class="admin-status-form">
                                    @csrf @method('PUT')
                                    <select name="status" class="status-select">
                                        <option value="0" {{ $statusRaw == 0 ? 'selected' : '' }}>New</option>
                                        <option value="1" {{ $statusRaw == 1 ? 'selected' : '' }}>Pending</option>
                                        <option value="2" {{ $statusRaw == 2 ? 'selected' : '' }}>Shipped</option>
                                        <option value="3" {{ $statusRaw == 3 ? 'selected' : '' }}>Completed</option>
                                        <option value="4" {{ $statusRaw == 4 ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="admin-btn-update">Update</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($user->orders->isEmpty())
                <div class="empty-orders text-center py-4">No active orders for this client.</div>
            @endif
        </div>
    @endforeach
</div>
@endsection