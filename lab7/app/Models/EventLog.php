<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    protected $fillable = [
        'event_type',
        'user_name',
        'user_email',
        'user_id',
        'message',
    ];
}
