<?php

namespace WiQ\Infrastructure\Client;

use WiQ\Infrastructure\Client\DTO\ConfigDTO;
use WiQ\Infrastructure\Client\Exception\ApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiGreatFoodClient
{
    private Client $http;
    private ?string $token = null;
    private ConfigDTO $config;

    public function __construct()
    {
        $this->config = new ConfigDTO();
        $this->http = new Client([
            'base_uri' => rtrim($this->config->baseUrl, '/') . '/',
            'timeout'  => 10,
        ]);
    }

    /**
     * POST /auth_token
     * @throws ApiException
     */
    public function getAuthToken(): array
    {
        try {
            $response = $this->http->post('auth_token', [
                'json' => [
                    'client_secret' => $this->config->clientSecret,
                    'client_id' => $this->config->clientId,
                    'grant_type' => $this->config->grantType
                ],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ]
            ]);
        } catch (GuzzleException $e) {
            throw new ApiException($e->getMessage(), $e->getCode(), $e);
        }

        $data = $this->decodeResponse($response->getBody()->getContents());

        $this->token = $data['access_token'] ?? null;

        if (!$this->token) {
            throw new ApiException('Token not present in response');
        }

        return $data;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * GET /menus
     * @throws ApiException
     */
    public function getMenus(): array
    {
        return $this->authorizedRequest('GET', 'menus');
    }

    /**
     * GET /menu/{menu_id}/products
     * @throws ApiException
     */
    public function getMenuProducts(int $menuId): array
    {
        return $this->authorizedRequest('GET', "menu/{$menuId}/products");
    }

    /**
     * PUT /menu/{menu_id}/product/{product_id}
     * @throws ApiException
     */
    public function updateProduct(int $menuId, int $productId, array $productData): array
    {
        return $this->authorizedRequest(
            'PUT',
            "menu/{$menuId}/product/{$productId}",
            $productData
        );
    }

    /**
     * Perform authorized HTTP request
     * @throws ApiException
     */
    private function authorizedRequest(string $method, string $uri, array $json = []): array
    {
        if (!$this->token) {
            throw new ApiException('Token not set. Call getAuthToken() first.');
        }

        try {
            $response = $this->http->request($method, $uri, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept' => 'application/json',
                ],
                'json' => $json ?: null,
            ]);
        } catch (GuzzleException $e) {
            throw new ApiException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->decodeResponse($response->getBody()->getContents());
    }

    /**
     * Decode JSON response
     * @throws ApiException
     */
    private function decodeResponse(string $body): array
    {
        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException('Invalid JSON response: ' . json_last_error_msg());
        }

        return $data;
    }
}
