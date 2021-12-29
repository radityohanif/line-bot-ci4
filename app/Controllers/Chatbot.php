<?php

namespace App\Controllers;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class Chatbot extends BaseController
{
    protected $replyToken;
    protected $bot;

    public function index($replyToken)
    {
        // Initial chatbot model
        $channel_access_token = "ddHYmFx/7KWWmM4V58v/zHvicDqidb0Vp8kplVVq0uQjbUexytmu563i1WBhC4fNEB41b4NNIhrwwWtGLFykJMf5zrhO9wsKrZQUFNnjZtKiPp8OvKPh3RpQbcP09DqYR/nKuiSItxw1iBlk1b6GzQdB04t89/1O/w1cDnyilFU=";
        $channel_secret = "f3dc9c53239aeab3dc0980c6b061cdac";
        $httpClient = new CurlHTTPClient($channel_access_token);
        $this->bot = new LINEBot($httpClient, ['channelSecret' => $channel_secret]);
        $this->replyToken = $replyToken;
        $this->bot->replyText($this->replyToken, "Assalamualaikum");
    }
}