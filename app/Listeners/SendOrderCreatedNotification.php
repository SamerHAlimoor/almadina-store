<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class SendOrderCreatedNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        //
        //$store = $event->order->store;
        $order = $event->order;

        Log::info("Order" . $order);

        /*
        $user = DB::table('users')->where('store_id', '=', $order->store_id)->first();
        Log::info("user" . $user);

        if ($user) {
            $user->notify(new OrderCreatedNotification($order));
            Log::info("Notification  Before Sent");

            // Notification::($user, new OrderCreatedNotification($order));
        }
        
        */
        $users = User::where('store_id', $order->store_id)->get();
        Notification::send($users, new OrderCreatedNotification($order));
        Log::info("Notification Sent");
    }
}