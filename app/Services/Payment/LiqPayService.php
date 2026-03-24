<?php 
namespace App\Services\Payment;

class LiqPayService
{
    private $publicKey;
    private $privateKey;

    public function __construct()
    {
        $this->publicKey = config('liqpay.public_key');
        $this->privateKey = config('liqpay.private_key');
    }

    public function getDataAndSignature($order)
    {
        $params = [
            'public_key'  => $this->publicKey,
            'version'     => '3',
            'action'      => 'pay',
            'amount'      => number_format((float)$order->total_price, 2, '.', ''),
            'currency'    => 'UAH',
            'description' => "Payment for Order #" . $order->id,
            'order_id'    => $order->id . '_' . time(),
            'sandbox'     => '1', 
            'result_url'  => route('home'),
            'server_url'  => route('payment.callback'),
        ];

        $data = base64_encode(json_encode($params));
        $signature = $this->generateSignature($data);

        return compact('data', 'signature');
    }

    public function generateSignature($data)
    {
        return base64_encode(sha1($this->privateKey . $data . $this->privateKey, true));
    }

    public function parseResponse($data)
    {
        return json_decode(base64_decode($data), true);
    }
}