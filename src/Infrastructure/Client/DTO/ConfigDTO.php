<?php

namespace WiQ\Infrastructure\Client\DTO;

class ConfigDTO
{
    public function __construct(
        public string $clientSecret	= '4j3g4gj304gj3',
        public string $clientId	= '1337',
        public string $grantType = 'client_credentials',
        public string $baseUrl	= 'php:8080',
    ) {

    }
}
