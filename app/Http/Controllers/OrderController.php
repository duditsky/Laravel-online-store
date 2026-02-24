<?php

namespace App\Http\Controllers;

use App\Models\Order;

use Illuminate\Http\Request;

class OrderController extends Controller
{
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
        ]);
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->shipping_method = $request->shipping_method;
        $order->payment_method = $request->payment_method;
        $order->status = 1;

        $user = $request->user();
        $order->user_id = $user ? $user->id : null;
        $order->save();

        session()->forget('orderId');
        
        return redirect()->route('home')->with('success', 'Order confirmed! Thank you.');
    }
}
