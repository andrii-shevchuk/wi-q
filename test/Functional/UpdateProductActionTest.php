<?php

namespace Test\Functional;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class UpdateProductActionTest extends TestCase
{
    private Client $client;
    private string $validToken = '33w4yh344go3u4h34yh93n4h3un4g34g';

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://php:8080',
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->validToken,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function testUpdateProduct(): void
    {
        $menuId = 7;
        $productId = 84;

        $payload = [
            'name' => 'Chips'
        ];

        $response = $this->client->put("/v1/menu/{$menuId}/products/{$productId}", [
            'json' => $payload
        ]);

        $this->assertEquals(200, $response->getStatusCode(), 'Expected HTTP 200');

        $data = json_decode((string) $response->getBody(), true);

        $expected = [
            'data' => [
                [
                    'id' => '84',
                    'name' => 'Chips'
                ]
            ]
        ];

        $this->assertEquals($expected, $data);
    }
}