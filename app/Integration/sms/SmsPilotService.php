<?php

namespace app\Integration\sms;

use yii\httpclient\Client;
use yii\httpclient\Exception;

class SmsPilotService
{
    private string $url = '';

    private string $apiKey = '';

    private string $sender = '';

    private ?Client $client = null;

    public function __construct()
    {
        $this->url = $_ENV['SMS_PILOT_URL'] ?? $this->url;
        $this->apiKey = $_ENV['SMS_PILOT_API_KEY'] ?? $this->apiKey;
        $this->sender = $_ENV['SMS_PILOT_SENDER'] ?? $this->sender;
    }

    /**
     * @throws Exception
     */
    public function send(string $phone, string $text)
    {
        return $this->getClient()
            ->get(
                url: $this->url,
                data: [
                    'send' => $text,
                    'to' => $phone,
                    'from' => $this->sender,
                    'apikey' => $this->apiKey,
                    'format' => 'json',
                ],
            )
            ->send()
            ->data;
    }

    public function getClient(): Client
    {
        if (!$this->client) {
            $this->client = new Client();
        }

        return $this->client;
    }
}