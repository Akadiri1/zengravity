<?php

$k = 'AIzaSyCq4ttbKUNMWCPcL4RwfWZx8bVKkJbR6D0';
$ms = [
    'v1beta/models/gemini-1.5-flash',
    'v1/models/gemini-1.5-flash',
    'v1beta/models/gemini-pro'
];

foreach ($ms as $m) {
    echo "Testing: $m\n";
    $u = "https://generativelanguage.googleapis.com/$m:generateContent?key=$k";
    $ch = curl_init($u);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"contents":[{"parts":[{"text":"Hi"}]}]}');
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $r = curl_exec($ch);
    $c = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo "Code: $c\n";
    if ($c != 200) {
        $j = json_decode($r, true);
        echo "Error: " . ($j['error']['message'] ?? $r) . "\n";
    }
    echo "----------------\n";
}
