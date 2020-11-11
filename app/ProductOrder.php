<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $fillable = [
        'product_id',
        'price',
        'service_payment_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
