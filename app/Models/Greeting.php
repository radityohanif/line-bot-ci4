<?php

namespace App\Model;

use CodeIgniter\Model;

class Greeting extends Model
{
    public function getReplyMessage()
    {
        return "Hola 🙂, from greeting model";
    }
}