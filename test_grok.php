<?php

use Illuminate\Support\Facades\Http;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = env('GROK_API_KEY');

echo "Grok Key loaded: " . substr($apiKey, 0, 8) . "...\n";

$url = 'https://api.x.ai/v1/chat/completions';
$jsonData = [
    'messages' => [
        [
            'role' => 'system',
            'content' => 'You are a test assistant.'
        ],
        [
            'role' => 'user',
            'content' => 'Testing. Just say hi and hello world and nothing else.'
        ]
    ],
    'model' => 'grok-2-latest', // fall back to grok-2 if 4 is not real yet
    'stream' => false,
    'temperature' => 0
];

echo "Testing connection to $url...\n";

try {
    $response = Http::withToken($apiKey)
        ->withHeaders([
            'Content-Type' => 'application/json'
        ])
        ->withOptions([
            'verify' => false, // For local WampServer
             'connect_timeout' => 45,
             'timeout' => 90
        ])
        ->post($url, $jsonData);

    if ($response->successful()) {
        echo "Response: " . $response->json()['choices'][0]['message']['content'] . "\n";
    } else {
        echo "Status: " . $response->status() . "\n";
        echo "Error: " . $response->body() . "\n";
    }
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
