<?php

namespace Verifiedit\LogNotifications\Listeners\LogNotification;

use Illuminate\Notifications\Events\NotificationSent;
use Verifiedit\LogNotifications\Contracts\LogNotificationProcessorContract;
use Carbon\CarbonImmutable;

class ClickSendLogNotificationProcessor implements LogNotificationProcessorContract
{
    public function process(NotificationSent $event): array
    {
        $data = [
            'application' => 'capture',
            'channel' => 'click-send',
            'reference' => $event->notification->id,
            'serviceCommunications' => json_encode($event->response) ?: '',
            'message' => '',
            'recipient' => (string)$event->notifiable->routeNotificationFor('click-send'),
            'sentAt' => CarbonImmutable::now(),
        ];

        if (method_exists($event->notification, 'toClickSend')) {
            $data['message'] = (string)$event->notification->toClickSend()->getContent();
        }

        return $data;
    }
}
