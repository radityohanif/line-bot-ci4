<?php

namespace App\Controllers;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class Webhook extends BaseController
{
    protected $replyToken;
    protected $bot;

    public function __construct()
    {
        // Initial chatbot model
        $channel_access_token = "ddHYmFx/7KWWmM4V58v/zHvicDqidb0Vp8kplVVq0uQjbUexytmu563i1WBhC4fNEB41b4NNIhrwwWtGLFykJMf5zrhO9wsKrZQUFNnjZtKiPp8OvKPh3RpQbcP09DqYR/nKuiSItxw1iBlk1b6GzQdB04t89/1O/w1cDnyilFU=";
        $channel_secret = "f3dc9c53239aeab3dc0980c6b061cdac";
        $httpClient = new CurlHTTPClient($channel_access_token);
        $this->bot = new LINEBot($httpClient, ['channelSecret' => $channel_secret]);
    }

    public function index()
    {
        // Get request body
        $body = $this->request->getBody();

        // Convert request data from json to array
        $this->request = json_decode($body, true);

        // Fetch request data
        foreach ($this->request['events'] as $event) {
            if ($event['type'] == 'message') {
                if ($event['message']['type'] == 'text') {
                    $this->replyToken = $event['replyToken'];
                    $this->test();
                }
            }
        }
    }

    public function test()
    {
        // susun pesan
        $jawaban = new MultiMessageBuilder();
        $jawaban->add(new TextMessageBuilder('Halo Selamat datang di warung pecel lele maju roso 😀'));
        $jawaban->add(new TextMessageBuilder('Kamu mau pesan apa..'));

        // kirim pesan
        $this->bot->replyMessage(
            $this->replyToken,
            $jawaban
        );
    }
}