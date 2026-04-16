<?php

namespace App\Jobs;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendOrderConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle(): void
    {
        $recipientEmail = $this->order->user?->email ?? $this->order->guest_email;

        if ($recipientEmail) {
            try {
                Mail::to($recipientEmail)->send(new OrderConfirmationMail($this->order));
                Log::info("Order confirmation email sent for order #{$this->order->id} to {$recipientEmail}");
            } catch (\Exception $e) {
                Log::error("Error sending confirmation for order #{$this->order->id}: " . $e->getMessage());
                throw $e;
            }
        } else {
            Log::warning("Missing email address for order #{$this->order->id}");
        }
    }
}
