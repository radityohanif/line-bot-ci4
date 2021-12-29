<?php

namespace App\Controllers;

use App\Model\Salam;
use App\Model\TerimaKasih;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class Webhook extends BaseController
{
    protected $replyToken;
    protected $lineBot;
    protected $salamModel;
    protected $terimaKasihModel;

    public function __construct()
    {
        $this->salamModel = new Salam();
        $this->terimaKasihModel = new TerimaKasih();

        // Initial chatlineBot model
        $channel_access_token = "ddHYmFx/7KWWmM4V58v/zHvicDqidb0Vp8kplVVq0uQjbUexytmu563i1WBhC4fNEB41b4NNIhrwwWtGLFykJMf5zrhO9wsKrZQUFNnjZtKiPp8OvKPh3RpQbcP09DqYR/nKuiSItxw1iBlk1b6GzQdB04t89/1O/w1cDnyilFU=";
        $channel_secret = "f3dc9c53239aeab3dc0980c6b061cdac";
        $httpClient = new CurlHTTPClient($channel_access_token);
        $this->lineBot = new LINEBot($httpClient, ['channelSecret' => $channel_secret]);
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
                    $this->replyToken = $event['replyToken'];   // set replyToken
                    $pesanMasuk = $event['message']['text'];

                    // menentukan kategori pesan masuk
                    $this->salamModel->setConfidence($pesanMasuk);
                    $this->terimaKasihModel->setConfidence($pesanMasuk);

                    $this->lineBot->replyText(
                        $this->replyToken,
                        "Salam Confidence = " . $this->salamModel->confidence . "\n" .
                            "Terima Kasih Confidence = " . $this->terimaKasihModel->confidence . "\n"
                    );
                }
            }
        }
    }

    public function salam()
    {
        $this->lineBot->replyText(
            $this->replyToken,
            "Halo selamat datang di warung pecel lele maju roso \nkamu mau pesan apa hari ini ?"
        );
    }
}