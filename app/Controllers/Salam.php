<?php

namespace App\Controllers;

use App\Controllers\Webhook;

class Salam extends Webhook
{
    public function kirimPesan()
    {
        $this->lineBot->replyText(
            $this->replyToken,
            'Halo, selamat datang di warung pecel lele maju roso \n kamu mau pesan apa hari ini ?'
        );
    }
}