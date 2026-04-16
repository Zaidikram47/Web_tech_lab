<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Models\EventLog;

class LogUserLoggedIn
{
    public function handle(UserLoggedIn $event): void
    {
        EventLog::create([
            'event_type' => 'User Logged In',
            'user_id'    => $event->user->id,
            'user_name'  => $event->user->name,
            'user_email' => $event->user->email,
            'message'    => 'User logged in: ' . $event->user->name,
        ]);
    }
}
