<?php

namespace App\Controllers;

class Webhook extends BaseController
{
    protected $chatbot;
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
                    $replyToken = $event['replyToken'];                 // Get replyToken
                    return redirect()->to('Chatbot/' . $replyToken);    // initial chatbot
                }
            }
        }
    }
}