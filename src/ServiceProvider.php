<?php

namespace Verifiedit\LogNotifications;

use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Event;
use Verifiedit\LogNotifications\Listeners\LogNotification\LogNotification;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register(): void
    {
        Event::listen(
            NotificationSent::class, LogNotification::class
        );
    }
}