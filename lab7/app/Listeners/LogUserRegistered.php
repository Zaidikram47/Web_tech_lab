<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\EventLog;

class LogUserRegistered
{
    public function handle(UserRegistered $event): void
    {
        EventLog::create([
            'event_type' => 'User Registered',
            'user_id'    => $event->user->id,
            'user_name'  => $event->user->name,
            'user_email' => $event->user->email,
            'message'    => 'New user registered: ' . $event->user->name,
        ]);
    }
}
