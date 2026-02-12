<?php

$apiKey = 'AIzaSyApKkqSuijXZpg0QRYSScbIub3tmZ_9Yjk';
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";

$data = [
    'contents' => [
        [
            'parts' => [
                ['text' => 'Hello, are you working?']
            ]
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Disable SSL verification for local dev to avoid cert issues (debugging only)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo 'Curl Error: ' . curl_error($ch);
} else {
    echo "HTTP Code: $httpCode\n";
    echo "Response Body:\n$response\n";
}

curl_close($ch);
