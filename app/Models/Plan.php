<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Cashier;

class Plan extends Model
{
    protected $guarded = [];

    public function price()
    {
        return Cashier::formatAmount($this->price, env('CASHIER_CURRENCY', 'usd'));
    }
}
