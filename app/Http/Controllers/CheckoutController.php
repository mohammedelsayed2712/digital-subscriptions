<?php
namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Plan $plan)
    {
        return Auth::user()->newSubscription($plan->slug, $plan->stripe_price_id)
        // ->allowPromotionCodes()
        // ->quantity(10)
            ->checkout([
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
        $plan         = Plan::findOrFail($request->plan_id);
        $query        = Auth::user()->newSubscription($plan->slug, $plan->stripe_price_id);
        $subscription = $query->when($plan->slug === 'yearly', function () use ($query) {
            return $query->trialDays(7);
        })
            ->create($request->payment_method);
        if ($subscription->stripe_status === 'active') {
            return redirect()->route('home', ['message' => 'Subscription Success!']);
        }
    }
}
