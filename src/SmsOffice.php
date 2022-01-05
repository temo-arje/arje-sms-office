<?php

namespace Arje\SmsOffice;

use GuzzleHttp\Client;
use Arje\SmsOffice\Exceptions\FailedToSendSms;
use GuzzleHttp\Exception\GuzzleException;

class SmsOffice
{

    const SEND_URL = '//smsoffice.ge/api/v2/send/?key=%s&destination=%s&sender=%s&content=%s&urgent=true';

    const BALANCE_URL = '//smsoffice.ge/api/getBalance?key=%s';

    protected object $client;

    protected string $apiKey;

    protected string $sender;

    protected string $driver;

    public function __construct()
    {
        $this->apiKey = config('arje_sms_office.key');
        $this->sender = config('arje_sms_office.sender');
        $this->client = new Client();
    }


    /**
     * @throws GuzzleException
     * @throws FailedToSendSms
     */
    public function send($to, $message): string
    {

        $this->checkParams();

        preg_match_all('!\d+!', $to, $matches);
        $to = implode($matches[0]);
        if (substr($to, 0, 3) != '995') {
            $to = '995' . $to;
        }// უთითებს ქვეყნის კოდს, იმ შემთხვევაში თუ ნომერში მითითებული არ იქნება ქვეყნის კოდი

        if (strlen($to) !== 12) {
            throw FailedToSendSms::invalidNumber();
        }

        if (strlen($message) !== strlen(utf8_decode($message))) {
            $message = rawurlencode($message);
        }

        $url = sprintf(self::SEND_URL, $this->apiKey, $to, $this->sender, $message);

        return $this->client->request('GET', $url)->getBody()->getContents();
    }

    /**
     * @return string
     * @throws GuzzleException
     */
    public function balance(): string
    {
        $url = sprintf(self::BALANCE_URL, $this->apiKey);

        return $this->client->request('GET', $url)->getBody()->getContents();
    }

    /**
     * @throws FailedToSendSms
     */
    private function checkParams()
    {
        if (empty($this->apiKey)) {
            throw FailedToSendSms::apiKeyNotProvided();
        }

        if (empty($this->sender)) {
            throw FailedToSendSms::senderNotProvided();
        }
    }

}
