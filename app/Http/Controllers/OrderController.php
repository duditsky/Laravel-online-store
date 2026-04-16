<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Services\Shipping\NovaPoshtaService;
use App\Jobs\SendOrderConfirmationEmail;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $novaPoshta;

    public function __construct(NovaPoshtaService $novaPoshta)
    {
        $this->novaPoshta = $novaPoshta;
    }
    public function orderPlace()
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            return redirect()->route('home');
        }
        $order = Order::find($orderId);

        if (is_null($order)) {
            session()->forget('orderId');

            return redirect()->route('home')->with('error', 'Your order was deleted due to inactivity.');
        }
        return view('order.order', compact('order'));
    }

    public function orderConfirm(Request $request)
    {


        $orderId = session('orderId');
        if (is_null($orderId)) {
            return redirect()->route('home');
        }

        $order = Order::find($orderId);
        if (is_null($order)) {
            session()->forget('orderId');
            return redirect()->route('home');
        }

        $request->validate([
            'name' => 'required|min:2|max:255',
            'phone' => 'required',
            'address' => 'required|min:5',
            'shipping_method' => 'required',
            'payment_method' => 'required',
            'city_name' => 'required_if:shipping_method,Nova Poshta',
            'warehouse_name' => 'required_if:shipping_method,Nova Poshta',
        ]);

        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->shipping_method = $request->shipping_method;
        $order->payment_method = $request->payment_method;
        if ($request->shipping_method === 'Nova Poshta') {
            $order->city = $this->novaPoshta->getCityNameByRef($request->city_name);
            $order->warehouse = $this->novaPoshta->getWarehouseNameByRef(
                $request->city_name,
                $request->warehouse_name
            );
            $order->city_ref = $request->city_name;
        }


        $order->status = 1;

        $order->total_price = $order->getFullPrice();

        $user = $request->user();
        $order->user_id = $user ? $user->id : null;
        $order->save();

        SendOrderConfirmationEmail::dispatch($order);

        session()->forget('orderId');


        if ($request->payment_method === 'liqpay') {
            return redirect()->route('payment.checkout', ['order' => $order->id]);
        }

        return redirect()->route('home')->with('success', 'Order confirmed! We will contact you.');
    }
    public function orders(Request $request)
    {
        $orders = $request->user()->orders()
            ->with(['products', 'posts'])
            ->latest()
            ->get();

        return view('order.orderPage', compact('orders'));
    }
    public function allOrders(Request $request)
    {
        $users = User::with(['orders.products'])
            ->whereHas('orders')
            ->latest()
            ->paginate(10);

        return view('order.allOrderPage', compact('users'));
    }
    public function changeStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:0,1,2,3,4',
        ]);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order #' . $order->id . ' status updated to ' . $order->status);
    }
}
