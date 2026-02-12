<?php

use Illuminate\Support\Facades\Http;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = config('services.openai.key') ?: env('OPENAI_API_KEY');

echo "OpenAI Key Configured: " . (empty($apiKey) ? "NO" : "YES (" . substr($apiKey, 0, 5) . "...)") . "\n";

$url = 'https://api.openai.com/v1/chat/completions';
$data = [
    'model' => 'gpt-4o',
    'messages' => [
        ['role' => 'user', 'content' => 'Hello, are you ready?']
    ],
    'max_tokens' => 10
];

echo "Testing OpenAI Connection...\n";

try {
    $response = Http::withToken($apiKey)->post($url, $data);
    
    echo "Status: " . $response->status() . "\n";
    if ($response->successful()) {
        echo "Response: " . $response->json()['choices'][0]['message']['content'] . "\n";
    } else {
        echo "Error: " . $response->body() . "\n";
    }
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
