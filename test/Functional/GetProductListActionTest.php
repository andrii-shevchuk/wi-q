<?php

namespace Test\Functional;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class GetProductListActionTest extends TestCase
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
            ],
        ]);
    }

    public function testGetTakeawayProducts(): void
    {
        $response = $this->client->get('/v1/menu/takeaway/products');

        $this->assertEquals(200, $response->getStatusCode(), 'Expected HTTP 200');

        $data = json_decode((string) $response->getBody(), true);

        $expected = [
            "data" => [
                ["id" => "1", "name" => "Large Pizza"],
                ["id" => "2", "name" => "Medium Pizza"],
                ["id" => "3", "name" => "Burger"],
                ["id" => "4", "name" => "Chips"],
                ["id" => "5", "name" => "Soup"],
                ["id" => "6", "name" => "Salad"],
            ]
        ];

        $this->assertEquals($expected, $data);
    }

    public function testGetTakeawayProductsMenuNotFound(): void
    {
        $response = $this->client->get('/v1/menu/nonexistent/products');

        $this->assertEquals(404, $response->getStatusCode(), 'Expected HTTP 404');

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('Menu "nonexistent" isn\'t found', $data['error']);
    }
}
