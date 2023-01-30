<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CartProduct extends Model
{
    protected $table = 'cart_product';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
