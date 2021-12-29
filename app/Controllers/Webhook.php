<?php

namespace App\Controllers;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\SignatureValidator as SignatureValidator;

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
        $this->channel_access_token = "ddHYmFx/7KWWmM4V58v/zHvicDqidb0Vp8kplVVq0uQjbUexytmu563i1WBhC4fNEB41b4NNIhrwwWtGLFykJMf5zrhO9wsKrZQUFNnjZtKiPp8OvKPh3RpQbcP09DqYR/nKuiSItxw1iBlk1b6GzQdB04t89/1O/w1cDnyilFU=";
        $this->channel_secret = "f3dc9c53239aeab3dc0980c6b061cdac";

        $this->pass_signature = false;
        $this->httpClient = new CurlHTTPClient($this->channel_access_token);
        $this->bot = new LINEBot($this->httpClient, ['channelSecret' => $this->channel_secret]);
    }

    public function index()
    {
        // get request body and line signature header
        $body = $this->request->getBody();
        $signature = $this->request->getHeaderLine("HTTP_X_LINE_SIGNATURE");

        // log body and signature
        file_put_contents('php://stderr', 'Body: ' . $body);

        if (!$this->pass_signature) {

            // if LINE_SIGNATURE exist in request header
            if (empty($signature)) {
                return "Signature does not exist, request fail";
            }

            // is this request comes from LINE?
            if (!SignatureValidator::validateSignature($body, $this->channel_secret, $signature)) {
                return "Signature is invalid, not from LINE";
            }
        }

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
            'Hello selamat datang di warung pecel lele seger roso :)'
        );
        $this->response->setContentType('application/json');
        $this->response->setStatusCode(200);
        $this->response->setJSON($this->request->getBody()->write(json_encode($result->getJSONDecodedBody())));
        return $this->response;
    }
}