<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function checkout(Order $order)
    {
        if ($order->user_id && Auth::id() !== $order->user_id) {
            abort(403, 'Unauthorized access to this order.');
        }

        $publicKey = config('liqpay.public_key');
        $privateKey = config('liqpay.private_key');

        $params = [
            'public_key'  => $publicKey,
            'version'     => '3',
            'action'      => 'pay',
            'amount'      => number_format((float)$order->total_price, 2, '.', ''),
            'currency'    => 'USD',
            'description' => "Payment for Order #" . $order->id,
            'order_id'    => $order->id . '_' . time(),
            'sandbox'     => '1',
            'result_url'  => route('home'),
            'server_url'  => route('payment.callback'),
        ];

        $data = base64_encode(json_encode($params));
        $signature = base64_encode(sha1($privateKey . $data . $privateKey, true));

        return view('order.payment_page', compact('data', 'signature', 'order'));
    }

    public function callback(Request $request)
    {
        $privateKey = config('liqpay.private_key');
        $data = $request->input('data');
        $signature = $request->input('signature');

        $generatedSignature = base64_encode(sha1($privateKey . $data . $privateKey, true));

        if ($signature === $generatedSignature) {
            $response = json_decode(base64_decode($data), true);

            $orderId = explode('_', $response['order_id'])[0];
            $order = Order::find($orderId);

            if ($order) {
                if (in_array($response['status'], ['success', 'sandbox', 'wait_accept'])) {
                    $order->update([
                        'payment_status' => 'paid',
                        'transaction_id' => $response['transaction_id'],
                        'status'         => 1,
                    ]);

                    Log::info("Order #{$orderId} paid successfully via LiqPay.");
                }
            }
        }

        return response('OK', 200);
    }
}
