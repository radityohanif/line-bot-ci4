<?php

namespace App\Controllers;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;

class Webhook extends BaseController
{
    protected $pass_signature;
    protected $channel_access_token;
    protected $channel_secret;
    protected $httpClient;
    protected $bot;
    protected $request;
    protected $replyToken;

    public function __construct()
    {
        // Sesuaikan dengan identitas chatbot
        $this->channel_access_token = "NbrmweDZ9dDYHaePjMsH4QaPyuNQXRTmdl0drAn112Tmurwl35ibzKCPWmZKZIkQSdvShINECInTnsyHUn7jQ4Rqbn2PC7YOR0oMiRZHwZ+IP3F1SI4FjEw1Q7ZpKs3RyB4ZOE8UGdtHrPVsmHvNBQdB04t89/1O/w1cDnyilFU=";
        $this->channel_secret = "07c25222ac6b0b0499f07127aac90e30";
        $this->httpClient = new CurlHTTPClient($this->channel_access_token);
        $this->bot = new LINEBot($this->httpClient, ['channelSecret' => $this->channel_secret]);
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
                    $this->hello();
                }
            }
        }
    }

    public function hello()
    {
        $result = $this->bot->replyText(
            $this->replyToken,
            'Hola 🙃'
        );
        $this->response->setContentType('application/json');
        $this->response->setStatusCode(200);
        $this->response->setJSON($this->request->getBody()->write(json_encode($result->getJSONDecodedBody())));
        return $this->response;
    }
}