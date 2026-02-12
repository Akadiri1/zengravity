<?php

$key = 'AIzaSyApKkqSuijXZpg0QRYSScbIub3tmZ_9Yjk';
$models = ['gemini-1.5-flash', 'gemini-pro-vision', 'gemini-pro'];

foreach ($models as $model) {
    echo "Testing Model: $model\n";
    $url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$key";
    
    $payload = [
        'contents' => [
            [
                'parts' => [
                    ['text' => 'Hello']
                ]
            ]
        ]
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if ($result === false) {
        echo "Curl Error: " . curl_error($ch) . "\n";
    } else {
        echo "HTTP Code: $httpCode\n";
        if ($httpCode !== 200) {
            $data = json_decode($result, true);
            $msg = $data['error']['message'] ?? substr($result, 0, 100);
            echo "API Error: $msg\n";
        } else {
            echo "SUCCESS!\n";
        }
    }
    curl_close($ch);
    echo "--------------------------------\n";
}
