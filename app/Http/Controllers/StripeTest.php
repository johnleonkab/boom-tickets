<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeTest extends Controller
{
    public function Test(){
        $stripe = new \Stripe\StripeClient(env('STRIPE_API_KEY'));
        $product = $stripe->products->create([
            'name' => 'Starter Subscription',
            'description' => '$12/Month subscription',
          ]);

          return $product;
          echo "Success! Here is your starter subscription product id: " . $product->id . "\n";
          
          $price = $stripe->prices->create([
            'unit_amount' => 1200,
            'currency' => 'usd',
            'recurring' => ['interval' => 'month'],
            'product' => $product['id'],
          ]);
          echo "Success! Here is your premium subscription price id: " . $price->id . "\n";
          
    }
}
