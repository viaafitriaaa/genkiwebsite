<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Bundle extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'student_only'
    ];
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'bundle_product')
                    ->withPivot('quantity');
    }
}
