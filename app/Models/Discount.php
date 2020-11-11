<?php

namespace App\Models;

use App\Currency;
use App\ServicePayment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_payment_id',
        'currency_id',
        'discount',
        'type',
    ];

    public function service_payment()
    {
        return $this->belongsTo(ServicePayment::class);
    }

    public function getcurrency(){
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
