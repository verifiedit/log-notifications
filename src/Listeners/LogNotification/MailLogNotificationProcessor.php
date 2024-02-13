<?php

namespace Verifiedit\LogNotifications\Listeners\LogNotification;

use Carbon\CarbonImmutable;
use Illuminate\Config\Repository;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Config;
use Verifiedit\LogNotifications\Contracts\LogNotificationProcessorContract;

class MailLogNotificationProcessor implements LogNotificationProcessorContract
{
    public function process(NotificationSent $event): array
    {
        $data = [
            'application' => Config::get('log-notifications.application-name'),
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
