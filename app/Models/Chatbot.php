<?php

namespace App\Models;

use codeigniter\Model;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use App\Models\Salam;

class Chatbot extends Model
{
    protected $channel_access_token;
    protected $channel_secret;
    protected $httpClient;
    protected $replyToken;
    protected $bot;

    public function __construct($replyToken)
    {
        // Initial chatbot model
        $this->channel_access_token = "ddHYmFx/7KWWmM4V58v/zHvicDqidb0Vp8kplVVq0uQjbUexytmu563i1WBhC4fNEB41b4NNIhrwwWtGLFykJMf5zrhO9wsKrZQUFNnjZtKiPp8OvKPh3RpQbcP09DqYR/nKuiSItxw1iBlk1b6GzQdB04t89/1O/w1cDnyilFU=";
        $this->channel_secret = "f3dc9c53239aeab3dc0980c6b061cdac";
        $this->httpClient = new CurlHTTPClient($this->channel_access_token);
        $this->bot = new LINEBot($this->httpClient, ['channelSecret' => $this->channel_secret]);
        $this->replyToken = $replyToken;

        $salam = new Salam();
        return $salam;
    }
}