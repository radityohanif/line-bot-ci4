<?php

namespace App\Model;

use CodeIgniter\Model;

class Chatbot extends model
{
    protected $incomingMessage;

    public function setIncomingMessage($message)
    {
        $this->incomingMessage = $message;
    }

    public function getReplyMessage()
    {
        return strtoupper($this->incomingMessage);
    }
}