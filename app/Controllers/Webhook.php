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
                    } else if ($event['message']['text'] == 'translate') {
                        $this->translate();
                    } else {
                        $this->bot->replyText($this->replyToken, 'Maaf aku gak ngerti 😢');
                    }
                }
            }
        }
    }

    public function greetingCallBack()
    {
        // try to get profile user from id
        $request = $this->bot->getProfile($this->userId);
        if ($request->isSucceeded()) {
            // get profile 
            $profile = $request->getJSONDecodedBody();
            // get first name
            $fullName   = explode(' ', $profile['displayName']);
            $firstName  = $fullName[0];
            // build message
            $message = new TextMessageBuilder('Halo ' . $firstName . ' ada yang bisa aku bantu');
            // send message
            $this->bot->replyMessage($this->replyToken, $message);
        }
    }

    public function thanksCallBack()
    {
        $message = new TextMessageBuilder('Sama-sama 😄');
        $this->bot->replyMessage(
            $this->replyToken,
            $message
        );
    }

    public function translate()
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://google-translate1.p.rapidapi.com/language/translate/v2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "q=Hello%2C%20world!&target=id&source=en",
            CURLOPT_HTTPHEADER => [
                "accept-encoding: application/gzip",
                "content-type: application/x-www-form-urlencoded",
                "x-rapidapi-host: google-translate1.p.rapidapi.com",
                "x-rapidapi-key: 6f0f67132fmshb13e46582fcb3ddp113e88jsn1066c39c8f21"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if (!$err) {
            // fetch response
            $response = json_decode($response, true);
            $translatedText = $response['data']['translations'][0]['translatedText'];
            // build & send message
            $this->bot->replyText($this->replyToken, $translatedText);
        }
    }
}