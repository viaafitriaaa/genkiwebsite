<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bundle;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'category'];

    public function bundles()
    {
        return $this->belongsToMany(Bundle::class, 'bundle_product')
                    ->withPivot('quantity');
    }
}
