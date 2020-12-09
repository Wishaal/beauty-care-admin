<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'number'
    ];


    public function payments()
    {
        return $this->hasMany(ServicePayment::class);
    }
}
