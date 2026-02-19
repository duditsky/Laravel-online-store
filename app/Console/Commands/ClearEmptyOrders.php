<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class ClearEmptyOrders extends Command
{
    /**
     * Usage: php artisan app:clear-empty-orders
     */
    protected $signature = 'app:clear-empty-orders';

    /**
     * Опис команди, який відображається у списку artisan.
     */
    protected $description = 'Delete abandoned orders (carts) that have not been confirmed for 24 hours';

    /**
     * Основна логіка виконання команди.
     */
    public function handle()
    {

        $orders = Order::where(function ($query) {
            $query->where('status', 0)
                ->orWhereNull('status');
        })
            ->where('created_at', '<', Carbon::now()->subDay())
            ->get();

        $count = $orders->count();

        if ($count === 0) {
            $this->info('No abandoned orders found.');
            return;
        }

        foreach ($orders as $order) {

            $order->products()->detach();

            $order->delete();
        }

        $this->info("Cleanup completed. Deleted {$count} abandoned orders.");
    }
}
