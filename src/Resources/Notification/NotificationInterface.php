<?php

namespace Oportunista\Resources\Notification;

interface NotificationInterface
{
    public function __construct(Message $message, $recipient);

    public function send();
}