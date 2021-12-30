<?php

namespace App\Controllers;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use App\Model\Chatbot;

class Webhook extends BaseController
{
    protected $replyToken;
    protected $LINEBot;
    protected $chatBotModel;

    public function __construct()
    {
        // Initial LINEBot
        $channel_access_token = "ddHYmFx/7KWWmM4V58v/zHvicDqidb0Vp8kplVVq0uQjbUexytmu563i1WBhC4fNEB41b4NNIhrwwWtGLFykJMf5zrhO9wsKrZQUFNnjZtKiPp8OvKPh3RpQbcP09DqYR/nKuiSItxw1iBlk1b6GzQdB04t89/1O/w1cDnyilFU=";
        $channel_secret = "f3dc9c53239aeab3dc0980c6b061cdac";
        $httpClient = new CurlHTTPClient($channel_access_token);
        $this->LINEBot = new LINEBot($httpClient, ['channelSecret' => $channel_secret]);

        // Initial ChatbotModel
        $this->chatBotModel = new Chatbot();
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
                    // set replyToken
                    $this->replyToken = $event['replyToken'];
                    // send incoming message to chatbot model
                    $this->chatBotModel->setIncomingMessage($event['message']['text']);
                    // reply message
                    $this->replyMessage();
                }
            }
        }
    }

    public function replyMessage()
    {
        // build reply message
        $replyMessage = new MultiMessageBuilder();
        // $replyMessage->add(new TextMessageBuilder($this->chatBotModel->getReplyMessage()));
        $replyMessage->add(new TextMessageBuilder('Mantap akhirnya berhasil👍'));
        $replyMessage->add(new TextMessageBuilder('Alhamdulillah'));

        // send reply message
        $this->LINEBot->replyMessage(
            $this->replyToken,
            $replyMessage
        );
    }
}