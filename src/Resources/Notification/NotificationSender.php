<?php

namespace Oportunista\Resources\Notification;


class NotificationSender
{
    private $messageObjects = Array();

    public function send()
    {
        foreach ($this->messageObjects as $message) {
            $message->send();
        }
    }

    public function add(NotificationInterface $message)
    {
        $this->messageObjects[] = $message;
    }
}