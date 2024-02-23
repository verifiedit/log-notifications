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
        $channel = $event->channel === 'NotificationChannels\\ClickSend\\ClickSendChannel' ? 'click-send' : $event->channel;

        $recipients = $this->formatRecipients($event->notifiable->routeNotificationFor($channel));

        $data = (new LogNotificationProcessorSelector())->select($event->channel)->process($event, $recipients);

        $this->api->store($data);
    }

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
