<?php

namespace Verifiedit\LogNotifications\Contracts;

interface NotificationLogContract
{
    /**
     * @param array{
     *    application: string,
     *    message: string,
     *    reference: string,
     *    recipient: string,
     *    serviceCommunications: string,
     *    channel: string,
     *    sentAt: string
     * } $data
     * @return array<string, mixed>
     */
    public function store(array $data): array;
}
