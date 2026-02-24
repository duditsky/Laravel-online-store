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
        $order = null;

        if (!is_null($orderId)) {
            $order = Order::find($orderId);
        }

        return view('product.basket', compact('order'));
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

            $product = Product::findOrFail($productId);

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

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "{$product->name} added to cart!",
                    'count' => $newCount,
                    'itemPrice' => number_format($product->price * $newCount, 2),
                    'fullCount' => (int) $order->products()->sum('order_product.count'),
                    'totalPrice' => number_format($order->getFullPrice(), 2)
                ]);
            }

            return back()->with('success', 'Product added!');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
    public function basketRemoveAll($productId, Request $request) 
    {
        $orderId = session('orderId');
        if (!is_null($orderId)) {
            $order = Order::find($orderId);
            $order->products()->detach($productId);
            $order->refresh();
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'totalPrice' => number_format($order->getFullPrice(), 2),
                'fullCount' => (int) $order->products()->sum('order_product.count')
            ]);
        }

        return redirect()->route('basket');
    }

    
}
