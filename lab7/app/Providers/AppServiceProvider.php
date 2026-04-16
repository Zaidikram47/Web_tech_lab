<?php

namespace App\Providers;

use App\Events\UserLoggedIn;
use App\Events\UserRegistered;
use App\Listeners\LogUserLoggedIn;
use App\Listeners\LogUserRegistered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(UserLoggedIn::class, LogUserLoggedIn::class);
        Event::listen(UserRegistered::class, LogUserRegistered::class);
    }
}
