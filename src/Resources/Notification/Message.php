<?php
declare(strict_types=1);

namespace Oportunista\Resources\Notification;


class Message
{
    private $message;
    private $subject;

    public function __construct(String $message, String $subject)
    {
        $this->message = $message;
        $this->subject = $subject;
    }
}