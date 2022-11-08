<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification as NotificationsNotification;
use Illuminate\Queue\InteractsWithQueue;
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



        $user = User::where('store_id', $order->store_id)->first();
        // dd($user);
        if ($user) {
            // $user->notifyNow(new OrderCreatedNotification($order));
            Log::info("Notification  Before Sent");

            Notification::sendNow($user, new OrderCreatedNotification($order));
        }
        Log::info("Notification Sent");
        /*
        $users = User::where('store_id', $order->store_id)->get();
        Notification::send($users, new OrderCreatedNotification($order));*/
    }
}