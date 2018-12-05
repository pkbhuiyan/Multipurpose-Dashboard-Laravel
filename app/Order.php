<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customerName','customer_id', 'size', 'address','topping'
    ];
}
