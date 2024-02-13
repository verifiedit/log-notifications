<?php

namespace Verifiedit\LogNotifications\Listeners\LogNotification;

use Carbon\CarbonImmutable;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Config;
use Verifiedit\LogNotifications\Contracts\LogNotificationProcessorContract;

class ClickSendLogNotificationProcessor implements LogNotificationProcessorContract
{

    public function process(NotificationSent $event): array
    {
        $data = [
            'application' => Config::get('log-notifications.application-name'),
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
