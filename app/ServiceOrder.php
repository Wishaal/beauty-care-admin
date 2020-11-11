<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $fillable = [
        'service_id',
        'price',
        'service_payment_id'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
