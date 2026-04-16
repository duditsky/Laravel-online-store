<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation #{{ $order->id }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { color: #0056b3; }
        .order-details, .product-list { margin-bottom: 20px; }
        .order-details ul, .product-list ul { list-style: none; padding: 0; }
        .order-details li, .product-list li { margin-bottom: 8px; }
        .product-list li strong { display: inline-block; min-width: 200px; }
        .total-price { font-weight: bold; font-size: 1.1em; color: #000; }
        .footer { text-align: center; margin-top: 30px; font-size: 0.9em; color: #777; }
        .currency { font-weight: normal; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Your Order!</h1>
            <p>Your order <strong>#{{ $order->id }}</strong> has been successfully placed.</p>
        </div>

        <div class="order-details">
            <h3>Order Details:</h3>
            <ul>
                <li><strong>Customer Name:</strong> {{ $order->user->name ?? $order->guest_name ?? 'Guest' }}</li>
                <li><strong>Email:</strong> {{ $order->user->email ?? $order->guest_email ?? 'Not provided' }}</li>
                <li><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</li>
                <li><strong>Shipping Status:</strong> {{ $order->delivery_status ?? 'Pending' }}</li>
                <li><strong>Shipping Address:</strong> {{ $order->delivery_address ?? 'Not provided' }}</li>
            </ul>
        </div>

        <div class="product-list">
            <h3>Items in Your Order:</h3>
            <ul>
                @forelse($order->products as $product)
                    <li>
                        <strong>{{ $product->name }}</strong>
                        <br>
                        {{ $product->pivot->quantity }} x {{ number_format($product->price, 2) }} UAH
                        
                        @if(isset($product->pivot->options) && is_array($product->pivot->options) && !empty($product->pivot->options))
                            <br>
                            <small style="color: #666;">
                                @foreach($product->pivot->options as $key => $value)
                                    {{ ucfirst($key) }}: {{ $value }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </small>
                        @endif
                    </li>
                @empty
                    <li>No items found in this order.</li>
                @endforelse
            </ul>
        </div>

        <div class="order-summary">
            <p class="total-price">
                <strong>Total Amount:</strong> {{ number_format($order->total_price, 2) }} UAH
            </p>
        </div>

        <div class="footer">
            <p>We will notify you as soon as your order is shipped.</p>
            <p>Best regards,<br><strong>JoyStore Tech Team</strong></p>
        </div>
    </div>
</body>
</html>