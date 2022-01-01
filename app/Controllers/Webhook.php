<?php

namespace App\Controllers;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;

class Webhook extends BaseController
{
    protected $replyToken;
    protected $bot;
    protected $userId;

    public function __construct()
    {
        // Sesuaikan dengan identitas chatbot
        $channel_access_token = "NbrmweDZ9dDYHaePjMsH4QaPyuNQXRTmdl0drAn112Tmurwl35ibzKCPWmZKZIkQSdvShINECInTnsyHUn7jQ4Rqbn2PC7YOR0oMiRZHwZ+IP3F1SI4FjEw1Q7ZpKs3RyB4ZOE8UGdtHrPVsmHvNBQdB04t89/1O/w1cDnyilFU=";
        $channel_secret = "07c25222ac6b0b0499f07127aac90e30";
        $httpClient = new CurlHTTPClient($channel_access_token);
        $this->bot = new LINEBot($httpClient, ['channelSecret' => $channel_secret]);
    }

    public function index()
    {
        // get request body and line signature header
        $body = $this->request->getBody();

        // log body and signature
        file_put_contents('php://stderr', 'Body: ' . $body);

        // Chatbot code start from here.. 👇👇
        // Fetch request data
        $this->request = json_decode($body, true);
        foreach ($this->request['events'] as $event) {
            if ($event['type'] == 'message') {
                if ($event['message']['type'] == 'text') {
                    $this->replyToken = $event['replyToken'];
                    $this->userId = $event['source']['userId'];
                    if (is_greeting($event['message']['text'])) {
                        $this->greetingCallBack();
                    } else if (is_thanks($event['message']['text'])) {
                        $this->thanksCallBack();
                    }
                }
            }
        }
    }

    function greetingCallBack()
    {
        // try to get profile user from id
        $request = $this->bot->getProfile($this->userId);
        if ($request->isSucceeded()) {
            // set profile 
            $profile = $request->getJSONDecodedBody();
            // build message
            $message = new TextMessageBuilder('Halo ' . $profile['displayName'] . ' ada yang bisa aku bantu');
            // send message
            $this->bot->replyMessage($this->replyToken, $message);
        }
    }

    function thanksCallBack()
    {
        $message = new TextMessageBuilder('Sama-sama 😄');
        $this->bot->replyMessage(
            $this->replyToken,
            $message
        );
    }
}