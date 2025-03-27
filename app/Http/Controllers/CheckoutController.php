<?php
namespace App\Http\Controllers;

use App\Models\Plan;
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
}
