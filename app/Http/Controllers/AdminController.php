<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('admin.dashboard', ['pageTitle' => 'Menu']);
    }

    public function CreateStripeAccount(){
        $stripe = new \Stripe\StripeClient(env('STRIPE_API_KEY'));
        $account = $stripe->accounts->create(['type' => 'express']);
        Admin::find(Auth::guard('admin')->user())->first()->organization->update([
            'stripe_user_id' => $account->id
        ]);
        $url = $stripe->accountLinks->create([
              'account' => $account->id,
              'refresh_url' => 'http://127.0.0.1:8000/admin/stripe/reauth',
              'return_url' => 'http://127.0.0.1:8000/admin/payments',
              'type' => 'account_onboarding',
            ]);
        return redirect($url->url);
    }

    public function getStripeData(){
        $stripe = new \Stripe\StripeClient(env('STRIPE_API_KEY'));
        $stripeAccount = $stripe->accounts->retrieve(Auth::guard('admin')->user()->organization->stripe_user_id,
            []
          );
        return view('admin.payments', ['pageTitle' => 'Pagos', 'payouts_enabled' => $stripeAccount->payouts_enabled]);
    }
}