<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    //
    public function show(Order $order)
    {
        $user = Auth::user()->id;
        if ($order->user_id === $user) {
            $delivery = $order->delivery()->select([
                'id',
                'order_id',
                'status',
                DB::raw("ST_Y(current_location) AS lat"),
                DB::raw("ST_X(current_location) AS lng"),
            ])->first();

            // return $delivery;
            return view('front.orders.show', [
                'order' => $order,
                'delivery' => $delivery,
            ]);
        } else {
            return abort(404);
        }
    }
}