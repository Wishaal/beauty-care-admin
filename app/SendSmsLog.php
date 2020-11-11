<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendSmsLog extends Model
{
    protected $table = 'sunaina_sms.send_sms_logs';
    protected $fillable = [
        'appointment_id',
        'number',
        'status',

    ];
}
