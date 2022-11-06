<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PaymentsController extends Controller
{
    //
    public function create(Order $order)
    {
        return view('front.payments.create', [
            'order' => $order,
        ]);
    }

    public function createStripePaymentIntent(Order $order)
    {

        $amount = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        /**
         * @var \Stripe\StripeClient
         */
        //   $stripe = App::make('stripe.client');
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));

        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => round($amount),
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        try {
            // Create payment
            $payment = new Payment();
            $payment->forceFill([
                'order_id' => $order->id,
                'amount' => $paymentIntent->amount,
                'currency' => $paymentIntent->currency,
                'method' => 'stripe',
                'status' => 'pending',
                'transaction_id' => $paymentIntent->id,
                'transaction_data' => json_encode($paymentIntent),
            ])->save();
        } catch (QueryException $e) {
            echo $e->getMessage();
            return;
        }

        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }

    public function confirm(Request $request, Order $order)
    {


        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));

        // $stripe = App::make('stripe.client');
        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->query('payment_intent'),
            []
        );


        //  dd($paymentIntent);

        if ($paymentIntent->status == 'succeeded') {
            try {
                $payment = Payment::where('order_id', $order->id)->first();
                $payment->forceFill([
                    'status' => 'completed',
                    'transaction_data' => json_encode($paymentIntent),
                ])->save();
            } catch (QueryException $e) {
                echo $e->getMessage();
                return;
            }

            // event('payment.created', $payment->id);

            return redirect()->route('home_page', [
                'status' => 'Payment-succeeded'
            ]);
        }

        return redirect()->route('orders.payments.create', [
            'order' => $order->id,
            'status' => $paymentIntent->status,
        ]);
    }
}