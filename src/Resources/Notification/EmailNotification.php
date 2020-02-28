<?php

namespace Oportunista\Resources\Notification;


class EmailNotification implements NotificationInterface
{
    private $recipientList;
    private $message;

    public function __construct(Message $message, $recipientList)
    {
        $this->message = $message;
        $this->recipientList = $recipientList;
    }

    public function send()
    {
        //TODO implementar
    }

}