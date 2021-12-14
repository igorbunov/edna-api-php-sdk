<?php

namespace igorbunov\Edna;

use GuzzleHttp\Client;
use igorbunov\Edna\Message\ImOutHSM;
use igorbunov\Edna\Message\ImOutMessage;
use igorbunov\Edna\Config\ConfigContract;
use igorbunov\Edna\MessageStatus\ImOutSuccess;
use igorbunov\Edna\Validator\ValicatorContract;
use igorbunov\Edna\MessageStatus\ImOutMessageStatus;

class EdnaJsonApi
{
    private $validator;
    private $guzzleClient;
    private $config;
    private $requestOptions;

    public const METHOD_GET = 'get';
    public const METHOD_POST = 'post';

    public function __construct(ConfigContract $config, ValicatorContract $validator)
    {
        $this->config = $config;
        $this->validator = $validator;

        $this->guzzleClient = new Client([
            'verify' => false,
            'http_errors' => false
        ]);

        $this->requestOptions = [
            'connect_timeout' => 10,
            'headers' => [
                'Content-Type' => 'application/json',
            ] + $this->config->keyHeader()
        ];
    }

    public function imOutMessage(ImOutMessage $message): ImOutSuccess
    {
        $response = $this->guzzleClient->request(
            self::METHOD_POST,
            $this->config->url('imOutMessage'),
            $this->requestOptions + [
                'body' => \json_encode($message->toArray())
            ]
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        $this->validator->validate($jsonResponse);

        return new ImOutSuccess($jsonResponse);
    }

    public function imOutMessageId(string $messageId): ImOutMessageStatus
    {
        $response = $this->guzzleClient->request(
            self::METHOD_GET,
            $this->config->url('imOutMessage') . '/' . $messageId,
            $this->requestOptions
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        $this->validator->validate($jsonResponse);

        return new ImOutMessageStatus($jsonResponse);
    }

    public function imOutHSM(ImOutHSM $message): ImOutSuccess
    {
        $response = $this->guzzleClient->request(
            self::METHOD_POST,
            $this->config->url('imOutHSM'),
            $this->requestOptions + [
                'body' => \json_encode($message->toArray())
            ]
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        $this->validator->validate($jsonResponse);

        return new ImOutSuccess($jsonResponse);
    }
}