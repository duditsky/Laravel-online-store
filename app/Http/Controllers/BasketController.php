<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function basket()
    {

        $orderId = session('orderId');
        if (is_null($orderId)) {
            return view('product.empty');
        } else {
            $order = Order::findOrFail($orderId);
            return view('product.basket', compact('order'));
        }
    }
    public function basketConfirm(Request $request)
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            return redirect()->route('home');
        }
        $user = $request->user();
        $order = Order::find($orderId);
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->shipping_method = $request->shipping_method;
        $order->payment_method = $request->payment_method;
        $order->status = 1;
        if (!$user) {
            $order->user_id = 1;
        } else {
            $order->user_id = $user->id;
        }

        $order->save();
        session()->forget('orderId');
        return redirect()->route('home');
    }


    public function basketPlace()
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            return redirect()->route('home');
        }
        $order = Order::find($orderId);
        return view('product.order', compact('order'));
    }
    public function basketAdd($productId)
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            $order = Order::create();
            session(['orderId' => $order->id]);
        } else {
            $order = Order::find($orderId);
        }
        if ($order->products->contains($productId)) {
            $prodCount = $order->products()->where('product_id', $productId)->first()->pivot;
            $prodCount->count++;
            $prodCount->update();
        } else {
            $order->products()->attach($productId);
        }
        return redirect()->route('basket');
    }
    public function basketRemove($productId)
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            return redirect()->route('basket');
        }
        $order = Order::find($orderId);

        if ($order->products->contains($productId)) {
            $prodCount = $order->products()->where('product_id', $productId)->first()->pivot;
            if ($prodCount->count < 2) {
                $order->products()->detach($productId);
            } else {
                $prodCount->count--;
                $prodCount->update();
            }
        }
        return redirect()->route('basket');
    }
}
