<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Transfer;
use Illuminate\Support\Str;

class StripeController extends Controller
{

    public function checkout() {
        if(request()->amount < 5) {
            return redirect(route('wallet', ['success' => 0, 'message' => 'Amount is not enought']));
        } else {
            $amount = request()->amount * 100;
        }

        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $salt = Str::random(40);

        $session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'aed',
                        'product_data' => [
                            'name' => 'charge'
                        ],
                        'unit_amount' => $amount
                    ],
                    'quantity' => 1
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('wallet', ['success' => '1', 'message' => 'charged!', 'code' => $salt]),
            'cancel_url' => route('wallet', ['success' => '0', 'message' => 'an error happened'])
        ]);

        Transfer::create([
            'user_id' => \Auth::id(),
            'amount' => convert_to_default_currency(request()->currency_id, request()->amount),
            'type' => 'charge',
            'verification_code' => $salt
        ]);

        return redirect()->away($session->url);
    }


}
