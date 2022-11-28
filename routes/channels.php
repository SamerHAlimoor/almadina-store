<?php

use App\Models\Order;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/


Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('deliveries.{order_id}', function ($user, $id) {
    $order = Order::findOrFail($id);
    // Log::info('Order=>' . $order);
    // Log::info('User=>' . $user);

    if ($order->user_id === $user->id) {
        return true;
    } else {
        return Log::info('Error with Auth=>' . $order . 'and ' . 'User=>' . $user);
    }
    // return (int) $order->user_id === (int) $user->id;
    return true;
});