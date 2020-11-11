<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'start',
        'end',
        'title',
        'description',
        'client_id',
        'color',
        'number'
    ];

}
