<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
        protected $fillable = [
        'order_id',
        'customer_name',
        'amount',
    ];
}
