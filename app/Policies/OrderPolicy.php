<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }


    /**
     * Determine if the user can view the order.
     */
    public function view(User $user, Order $order)
    {

        return $user->id === $order->user_id;
    }
}
