<?php

namespace App\Models;

use App\Models\Chatbot;

class Salam extends Chatbot
{
    public function __construct()
    {
        return $this->bot->replyText(
            $this->replyToken,
            "Hello :)"
        );
    }
}