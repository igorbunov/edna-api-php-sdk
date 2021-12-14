<?php

namespace igorbunov\Edna\Config;

use igorbunov\Edna\Config\ConfigContract;

class Config implements ConfigContract
{
    private $apiUrl;
    private $apiKey;

    public function __construct(
        string $apiKey,
        string $aipUrl = 'https://im.edna.ru/api/'
    ) {
        $this->apiUrl = $aipUrl;
        $this->apiKey = $apiKey;
    }

    public function url(string $url): string
    {
        // TODO: add check for slesh
        return $this->apiUrl . $url;
    }

    public function keyHeader(): array
    {
        return [
            'X-API-KEY' => $this->apiKey
        ];
    }
}