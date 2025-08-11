<?php

namespace Verifiedit\LogNotifications\Listeners\LogNotification;

use Carbon\CarbonImmutable;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Config;
use Verifiedit\LogNotifications\Contracts\LogNotificationProcessorContract;

class MicrosoftTeamsLogNotificationProcessor implements LogNotificationProcessorContract
{
    public function process(NotificationSent $event, string $recipients): array
    {
        $data = [
            'application' => Config::get('log-notifications.application-name'),
            'channel' => 'microsoft-teams',
            'reference' => $event->notification->id,
            'serviceCommunications' => json_encode($event->response) ?: '',
            'message' => '',
            'recipient' => $recipients,
            'sentAt' => CarbonImmutable::now(),
            'subject' => null
        ];

        if (method_exists($event->notification, 'toMicrosoftTeams')) {
            $data['message'] = json_encode($event->notification->toMicrosoftTeams($event->notifiable)->toArray());
        }

        return $data;
    }
}
