<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendOrderNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        $admin = User::where('role', 'admin')->first();
        // just a trigger
        // Mail::to($admin->email)->send(new OrderPlacedNotification($event->order));
        Log::info('Order placed notification triggered for admin.', ['order_id' => $event->order->id]);
    }
}
