<?php

$apiKey = 'AIzaSyApKkqSuijXZpg0QRYSScbIub3tmZ_9Yjk';
$url = "https://generativelanguage.googleapis.com/v1beta/models?key=$apiKey";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    $err = 'Curl Error: ' . curl_error($ch) . "\n";
    file_put_contents('available_models.txt', $err);
    echo $err;
} else {
    $data = json_decode($response, true);
    
    file_put_contents('available_models.json', json_encode($data, JSON_PRETTY_PRINT));
    echo "List saved to available_models.json\n";
}

curl_close($ch);
