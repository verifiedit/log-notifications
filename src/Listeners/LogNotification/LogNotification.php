<?php

namespace Verifiedit\LogNotifications\Listeners\LogNotification;

use Exception;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Log;
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
        Log::info('NOTIFICATION EVENT', [$event]);
        $recipients = $this->formatRecipients($event->notifiable->getRouteNotificationFor($event->channel));

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
