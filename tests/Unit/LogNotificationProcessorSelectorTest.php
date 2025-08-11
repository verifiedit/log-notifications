<?php

use Verifiedit\LogNotifications\Listeners\LogNotification\ClickSendLogNotificationProcessor;
use Verifiedit\LogNotifications\Listeners\LogNotification\LogNotificationProcessorSelector;
use Verifiedit\LogNotifications\Listeners\LogNotification\MailLogNotificationProcessor;
use Verifiedit\LogNotifications\Listeners\LogNotification\MicrosoftTeamsLogNotificationProcessor;

it(
    'returns the correct processor',
    /**
     * @throws Exception
     */
    function (string $channel) {
        $selector = new LogNotificationProcessorSelector();
        $processor = $selector->select($channel);
        match ($channel) {
            'click-send' => expect($processor)->toBeInstanceOf(
                ClickSendLogNotificationProcessor::class
            ),
            'mail' => expect($processor)->toBeInstanceOf(MailLogNotificationProcessor::class),
            'microsoft-teams' => expect($processor)->toBeInstanceOf(
                MicrosoftTeamsLogNotificationProcessor::class),
            default => throw new Exception("$channel log notification processor not implemented"),
        };
    }
)->with(['click-send', 'mail', 'microsoft-teams']);

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
