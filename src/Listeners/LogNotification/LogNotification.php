<?php

namespace Verifiedit\LogNotifications\Listeners\LogNotification;

use Exception;
use Illuminate\Notifications\Events\NotificationSent;
use Verifiedit\LogNotifications\Contracts\NotificationLogContract;

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
        $channel = match ($event->channel) {
            'mail' => 'mail',
            'NotificationChannels\\ClickSend\\ClickSendChannel' => 'click-send',
            'NotificationChannels\\MicrosoftTeams\\MicrosoftTeamsChannel' => 'microsoft-teams',
            default => throw new Exception("{$event->channel} log notification processor not implemented"),
        };

        $recipients = $this->formatRecipients($event->notifiable->routeNotificationFor($channel));

        $data = (new LogNotificationProcessorSelector())->select($channel)->process($event, $recipients);

        $this->api->store($data);
    }

    /**
     * @param array<int|string, string>|string $recipients
     */
    private function formatRecipients(array|string $recipients): string
    {
        if (!is_array($recipients)) {
            return $recipients;
        }

        return collect($recipients)->reduce(function (string $carry, string|int $value, string|int $key) {
            $recipient = is_string($key)
                ? $value . ' <' . $key . '>'
                : (string)$value;
            return $carry !== '' ? $carry . ', ' . $recipient : $recipient;
        }, '');
    }
}
