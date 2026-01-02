<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'method',
        'qris_data',
        'amount'
    ];

    // Payment milik 1 Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
