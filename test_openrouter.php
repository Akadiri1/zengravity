<?php

use Illuminate\Support\Facades\Http;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = config('services.openrouter.key') ?: env('OPENROUTER_API_KEY');

// Verify key loaded
echo "OpenRouter Key Config: " . substr($apiKey, 0, 5) . "..." . substr($apiKey, -5) . "\n";

$url = 'https://openrouter.ai/api/v1/chat/completions';
$data = [
    'model' => 'google/gemma-3-12b-it:free',
    'messages' => [
        ['role' => 'user', 'content' => 'Hello, confirm you are reachable.']
    ],
    'max_tokens' => 20
];

echo "Testing connection...\n";

try {
    $response = Http::withToken($apiKey)
        ->withOptions([
            'verify' => false,
            'connect_timeout' => 45,
            'timeout' => 90,
            'force_ip_resolve' => 'v4',
        ])
        ->withHeaders([
            'HTTP-Referer' => 'http://localhost',
            'X-Title' => 'ZenGravity App',
        ])
        ->post($url, $data);

    if ($response->successful()) {
        echo "Response: " . $response->json()['choices'][0]['message']['content'] . "\n";
    } else {
        file_put_contents('openrouter_error.json', $response->body());
        echo "Status: " . $response->status() . "\n";
        echo "Error: " . $response->body() . "\n";
    }
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
