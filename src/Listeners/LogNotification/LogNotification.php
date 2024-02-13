<?php

namespace Verifiedit\LogNotifications\Listeners\LogNotification;

use Verifiedit\LogNotifications\Contracts\NotificationLogContract;
use Exception;
use Illuminate\Notifications\Events\NotificationSent;

readonly class LogNotification
{
    public function __construct(private NotificationLogContract $api)
    {
    }

    /**
     * @throws Exception
     */
    public function handle(NotificationSent $event): void
    {
        $data = (new LogNotificationProcessorSelector())->select($event->channel)->process($event);

        $this->api->store($data);
    }
}
