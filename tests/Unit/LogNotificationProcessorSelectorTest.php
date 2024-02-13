<?php

use Verifiedit\LogNotifications\Listeners\LogNotification\ClickSendLogNotificationProcessor;
use Verifiedit\LogNotifications\Listeners\LogNotification\LogNotificationProcessorSelector;
use Verifiedit\LogNotifications\Listeners\LogNotification\MailLogNotificationProcessor;

it(
    'returns the correct processor',
    /**
     * @throws Exception
     */
    function (string $channel) {
        $selector = new LogNotificationProcessorSelector();
        $processor = $selector->select($channel);
        match ($channel) {
            'NotificationChannels\\ClickSend\\ClickSendChannel' => expect($processor)->toBeInstanceOf(
                ClickSendLogNotificationProcessor::class
            ),
            'mail' => expect($processor)->toBeInstanceOf(MailLogNotificationProcessor::class),
            default => throw new Exception("$channel log notification processor not implemented"),
        };
    }
)->with(['NotificationChannels\\ClickSend\\ClickSendChannel', 'mail']);

it(
    'should throw exception if notification driver not implemented',
    /**
     * @throws Exception
     */
    function (): void {
        $selector = new LogNotificationProcessorSelector();
        $selector->select('unknown');
    }
)->throws(Exception::class, 'unknown log notification processor not implemented');
