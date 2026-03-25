<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Payment\LiqPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $liqPay;

    public function __construct(LiqPayService $liqPay)
    {
        $this->liqPay = $liqPay;
    }

    public function checkout(Order $order)
    {
        if ($order->user_id && Auth::id() !== $order->user_id) {
            abort(403, 'Unauthorized access to this order.');
        }

        $paymentData = $this->liqPay->getDataAndSignature($order);

        return view('order.payment_page', array_merge($paymentData, ['order' => $order]));
    }

    public function callback(Request $request)
    {
        $data = $request->input('data');
        $signature = $request->input('signature');

        if ($signature === $this->liqPay->generateSignature($data)) {

            $response = $this->liqPay->parseResponse($data);

            $orderId = explode('_', $response['order_id'])[0];
            $order = Order::find($orderId);

            if ($order) {
                if ($order->payment_status === 'paid') {
                    return response('OK', 200);
                }

                $liqpayAmount = (float)$response['amount'];
                $orderAmount = (float)$order->total_price;

                if ($liqpayAmount !== $orderAmount || $response['currency'] !== 'UAH') {
                    Log::warning("Order #{$orderId}: Amount or currency mismatch! LiqPay: {$liqpayAmount} {$response['currency']}, Database: {$orderAmount} UAH");

                    return response('OK', 200);
                }

                if (in_array($response['status'], ['success', 'sandbox', 'wait_accept'])) {
                    $order->update([
                        'payment_status' => 'paid',
                        'transaction_id' => $response['transaction_id'],
                        'status'         => 1,
                    ]);

                    Log::info("Order #{$orderId}: Payment successful. Amount: {$liqpayAmount} UAH.");
                } elseif (in_array($response['status'], ['failure', 'error', 'reversed'])) {
                    $order->update([
                        'payment_status' => 'error',
                    ]);

                    Log::warning("Order #{$orderId}: Payment declined. Status: {$response['status']}. Reason: " . ($response['err_description'] ?? 'not specified'));
                }
            }
        }

        return response('OK', 200);
    }
}
