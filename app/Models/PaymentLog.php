<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
