<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;

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
   public function basketAdd($productId, Request $request)
    {
        try {
            $quantity = (int) $request->input('quantity', 1);
            $orderId = session('orderId');

            if (is_null($orderId)) {
                $order = Order::create();
                session(['orderId' => $order->id]);
            } else {
                $order = Order::find($orderId);
            }

            if ($order->products->contains($productId)) {
                $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
                $pivotRow->count += $quantity;
                $pivotRow->update();
                $newCount = $pivotRow->count;
            } else {
                $order->products()->attach($productId, ['count' => $quantity]);
                $newCount = $quantity;
            }

            $order->refresh();
            $product = Product::find($productId);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'count' => $newCount,
                    'itemPrice' => number_format($product->price * $newCount, 2),
                    'totalPrice' => number_format($order->getFullPrice(), 2),
                    'fullCount' => (int) $order->products()->sum('order_product.count')
                ]);
            }

            return redirect()->route('basket')->with('success', 'Product added to cart!');
            
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function basketRemove($productId, Request $request)
    {
        try {
            $orderId = session('orderId');
            if (is_null($orderId)) {
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }

            $order = Order::find($orderId);
            $newCount = 0;

            if ($order->products->contains($productId)) {
                $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
                if ($pivotRow->count < 2) {
                    $order->products()->detach($productId);
                    $newCount = 0;
                } else {
                    $pivotRow->count--;
                    $pivotRow->update();
                    $newCount = $pivotRow->count;
                }
            }

            $order->refresh();
            $product = Product::find($productId);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'count' => $newCount,
                    'itemPrice' => number_format($product ? $product->price * $newCount : 0, 2),
                    'totalPrice' => number_format($order->getFullPrice(), 2),
                    'fullCount' => (int) $order->products()->sum('order_product.count')
                ]);
            }

            return redirect()->route('basket');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function basketRemoveAll($productId)
    {
        $orderId = session('orderId');
        if (!is_null($orderId)) {
            $order = Order::find($orderId);
            $order->products()->detach($productId);
        }

        return redirect()->route('basket')->with('warning', 'Product removed from cart.');
    }
}
