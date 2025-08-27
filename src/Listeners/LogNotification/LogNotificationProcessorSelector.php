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
            'click-send' => new ClickSendLogNotificationProcessor(),
            'microsoft-teams' => new MicrosoftTeamsLogNotificationProcessor(),
            default => throw new Exception("$channel log notification processor not implemented"),
        };
    }
}
