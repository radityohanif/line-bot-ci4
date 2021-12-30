<?php

namespace App\Model;

use CodeIgniter\Model;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class Chatbot extends model
{
    public function getReplyMessage()
    {
        return new TextMessageBuilder('hello');
    }
}