<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'type_id',
        'name',
        'price',
        'currency_id'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
