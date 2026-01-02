<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Order extends Model
{
    protected $fillable = [
        'total',
        'total_after_promo',
        'status',
        'paid_at',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_city',
        'customer_postal_code',
        'is_promo',
        'promo_proof_path',
        'promo_verified_at',
        'promo_discount_percent',
        
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
}
