<?php

namespace Verifiedit\LogNotifications;

use Exception;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Event;
use Verifiedit\LogNotifications\Listeners\LogNotification\LogNotification;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @throws Exception
     */
    public function boot(): void
    {
        if (!function_exists('config_path')) {
            throw new Exception('Please install in a Laravel project to use this package.');
        }

        $this->publishes(
            [
                __DIR__ . '/../config/config.php' => config_path('log-notifications.php'),
            ],
            'log-notifications-config'
        );
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'log-notifications');

        Event::listen(
            NotificationSent::class, LogNotification::class
        );
    }
}