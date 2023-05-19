<?php

namespace App\Listeners;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DecrementProductQuantity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Order  $event
     * @return void
     */
    public function handle(Order $order)
    {
        foreach ($order->order_products as $p) {
            Product::findOrFail($p->id)->decrement('quantity',$p->quantity);
        }
    }
}
