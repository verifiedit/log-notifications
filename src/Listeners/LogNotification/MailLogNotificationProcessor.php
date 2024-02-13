<?php

namespace Verifiedit\LogNotifications\Listeners\LogNotification;

use Carbon\CarbonImmutable;
use Verifiedit\LogNotifications\Contracts\LogNotificationProcessorContract;
use Illuminate\Notifications\Events\NotificationSent;

class MailLogNotificationProcessor implements LogNotificationProcessorContract
{
    public function process(NotificationSent $event): array
    {
        $data = [
            'application' => 'capture',
            'channel' => 'mail',
            'reference' => $event->notification->id,
            'serviceCommunications' => json_encode($event->response) ?: '',
            'message' => '',
            'recipient' => (string)$event->notifiable->routeNotificationFor('mail'),
            'sentAt' => CarbonImmutable::now(),
        ];

        if (method_exists($event->notification, 'toMail')) {
            $data['message'] = (string)$event->notification->toMail($event->notifiable)->render();
        }

        return $data;
    }
}
