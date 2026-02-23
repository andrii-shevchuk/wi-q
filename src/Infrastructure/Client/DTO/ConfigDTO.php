<?php

namespace WiQ\Infrastructure\Client\DTO;

class ConfigDTO
{
    public function __construct(
        public string $clientSecret = '',
        public string $clientId = '',
        public string $grantType = '',
        public string $baseUrl = '',
    ) {
        $this->clientSecret = $this->clientSecret ?: getenv('CLIENT_SECRET') ?: '';
        $this->clientId     = $this->clientId ?: getenv('CLIENT_ID') ?: '';
        $this->grantType    = $this->grantType ?: getenv('GRANT_TYPE') ?: '';
        $this->baseUrl      = $this->baseUrl ?: getenv('BASE_URL') ?: '';
    }
}
