<?php
namespace App\Console\Commands;

use App\Models\Plan;
use Illuminate\Console\Command;

class StripePlansCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:plans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stripe plans';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $plans  = $stripe->products->all();

        foreach ($plans->data as $plan) {
            $price = $stripe->prices->retrieve($plan->default_price, []);
            Plan::updateOrCreate([
                'name'            => $plan->name,
                'slug'            => str_replace(' ', '-', strtolower($plan->name)),
                'price'           => $price->unit_amount,
                'interval'        => $price->recurring->interval,
                'stripe_price_id' => $price->id,
            ]);
        }

    }
}
