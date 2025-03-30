<?php
namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Plan $plan)
    {
        return Auth::user()->newSubscription($plan->slug, $plan->stripe_price_id)->checkout([
            'success_url' => route('home', ['message' => 'Subscription Success!']),
            'cancel_url'  => route('plans', ['message' => 'Payment Cancel!']),
        ]);
    }

    public function index2(Plan $plan)
    {
        return view('checkout.payment-method', get_defined_vars());
    }

    public function post(Request $request)
    {
        $plan    = Plan::findOrFail($request->plan_id);
        $payment = Auth::user()->newSubscription($plan->slug, $plan->stripe_price_id)->create($request->payment_method);
        dd($payment);
    }
}
