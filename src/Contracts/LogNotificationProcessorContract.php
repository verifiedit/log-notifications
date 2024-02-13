<?php

namespace Verifiedit\LogNotifications\Contracts;

use Illuminate\Notifications\Events\NotificationSent;

interface LogNotificationProcessorContract
{
    /**
     * @param NotificationSent $event
     * @return array{
     *     application: string,
     *     message: string,
     *     reference: string,
     *     recipient: string,
     *     serviceCommunications: string,
     *     channel: string,
     *     sentAt: string
     * }
     */
    public function process(NotificationSent $event): array;
}
