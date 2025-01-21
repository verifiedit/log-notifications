<?php

namespace Verifiedit\LogNotifications\Contracts;

use Illuminate\Notifications\Events\NotificationSent;

interface LogNotificationProcessorContract
{
    /**
     * @param NotificationSent $event
     * @param string $recipients
     * @return array{
     *     application: string,
     *     message: string,
     *     reference: string,
     *     recipient: string,
     *     serviceCommunications: string,
     *     channel: string,
     *     sentAt: string,
     *     subject: string|null
     * }
     */
    public function process(NotificationSent $event, string $recipients): array;
}
