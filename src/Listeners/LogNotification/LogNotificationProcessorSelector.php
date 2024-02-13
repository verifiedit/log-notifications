<?php

namespace Verifiedit\LogNotifications\Listeners\LogNotification;

use Verifiedit\LogNotifications\Contracts\LogNotificationProcessorContract;
use Exception;

class LogNotificationProcessorSelector
{
    /**
     * @throws Exception
     */
    public function select(string $channel): LogNotificationProcessorContract
    {
        return match ($channel) {
            'mail' => new MailLogNotificationProcessor(),
            'NotificationChannels\\ClickSend\\ClickSendChannel' => new ClickSendLogNotificationProcessor(),
            default => throw new Exception("$channel log notification processor not implemented"),
        };
    }
}
