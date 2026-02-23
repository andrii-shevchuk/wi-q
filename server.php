<?php

// Great Food Mock API Server
// Run: php -S 0.0.0.0:8080 server.php

header('Content-Type: application/json');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$responsesDir = __DIR__ . '/responses';

$menus = json_decode(file_get_contents($responsesDir . '/menus.json'), true);
$products = json_decode(file_get_contents($responsesDir . '/menu-products.json'), true);
$tokenData = json_decode(file_get_contents($responsesDir . '/token.json'), true);

$validToken = $tokenData['access_token'] ?? null;

function sendJson($data, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function getBearerToken(): ?string
{
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        return null;
    }
    if (preg_match('/Bearer\s+(.*)$/i', $headers['Authorization'], $matches)) {
        return $matches[1];
    }
    return null;
}

function requireAuth(string $validToken): void
{
    $token = getBearerToken();
    if (!$token || $token !== $validToken) {
        sendJson(['error' => 'Unauthorized'], 401);
    }
}

/*
|--------------------------------------------------------------------------
| ROUTES
|--------------------------------------------------------------------------
*/

// ---------------- AUTH (no token required)
if ($uri === '/auth_token' && $method === 'POST') {
    sendJson($tokenData);
}

// ---------------- MENUS (auth required)
if ($uri === '/menus' && $method === 'GET') {
    requireAuth($validToken);
    sendJson($menus);
}

// ---------------- PRODUCTS LIST
if (preg_match('#^/menu/(\d+)/products$#', $uri, $m) && $method === 'GET') {
    requireAuth($validToken);
    $menuId = (int)$m[1];

    // If products contain menu_id → filter
    $filtered = array_filter($products, function ($p) use ($menuId) {
        return !isset($p['menu_id']) || $p['menu_id'] == $menuId;
    });

    sendJson($filtered);
}

// ---------------- UPDATE PRODUCT
if (preg_match('#^/menu/(\d+)/product/(\d+)$#', $uri, $m) && $method === 'PUT') {
    requireAuth($validToken);

    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        sendJson(['error' => 'Invalid JSON'], 400);
    }

    // Just echo back as confirmation
    sendJson([
        'data' => $input
    ]);
}

// ---------------- DEFAULT
sendJson(['error' => 'Not found'], 404);
