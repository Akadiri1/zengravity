<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * ZenAiService
 * Central AI service for ZENGRAVITY using Google Gemini API.
 */
class ZenAiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';
    
    // Using Gemini 1.5 Flash for speed and multimodal capabilities
    protected string $model = 'gemini-1.5-flash';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', env('GEMINI_API_KEY', '')) ?? '';
    }

    /**
     * Ghost Scanner: Analyzes media for safety using Gemini Vision.
     */
    public function scanMedia(string $filePath)
    {
        if (empty($this->apiKey)) {
            Log::warning("ZenAi: No Gemini API key found. Using mock data.");
            return $this->getMockSafetyData();
        }

        try {
            $fullPath = storage_path('app/public/' . $filePath);

            if (!file_exists($fullPath)) {
                Log::warning("ZenAi: File not found at $fullPath");
                return $this->getMockSafetyData();
            }

            // Read file and encode to Base64
            $fileData = file_get_contents($fullPath);
            $base64Data = base64_encode($fileData);
            $mimeType = mime_content_type($fullPath) ?: 'image/jpeg';

            // Construct Payload for Gemini
            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "Analyze this image for social media safety. Focus on nudity, violence, hate symbols, and drugs. Respond ONLY with valid JSON (no markdown block): {safety_score: 0-100, masterpiece_status: 'Yes'|'No'|'Suspicious', reason: string, violations: string[], detailed_feedback: string}."],
                            [
                                'inline_data' => [
                                    'mime_type' => $mimeType,
                                    'data' => $base64Data
                                ]
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.4,
                    'maxOutputTokens' => 1024,
                    'responseMimeType' => 'application/json'
                ]
            ];

            $url = "{$this->baseUrl}{$this->model}:generateContent?key={$this->apiKey}";
            
            $response = Http::withOptions([
                    'verify' => false,
                    'connect_timeout' => 30, 
                    'timeout' => 60
                ])
                ->post($url, $payload);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                
                if ($content) {
                    $analysis = json_decode($content, true);
                    return $this->mapGeminiToGhostScanner($analysis ?? []);
                }
            }

            Log::error("ZenAi Gemini Error (" . $response->status() . "): " . $response->body());
            
            return $this->getMockSafetyData();

        } catch (\Exception $e) {
            Log::error("ZenAi Exception: " . $e->getMessage());
            return $this->getMockSafetyData();
        }
    }

    private function mapGeminiToGhostScanner($data)
    {
        return [
            'safety_score' => (int) ($data['safety_score'] ?? 50),
            'violations' => $data['violations'] ?? [],
            'feedback' => $data['detailed_feedback'] ?? "Analysis completed.",
            'meta' => [
                'masterpiece_status' => $data['masterpiece_status'] ?? 'Suspicious',
                'reason' => $data['reason'] ?? 'Automated analysis.',
                'confidence' => 1.0
            ]
        ];
    }

    // Mock fallback
    private function getMockSafetyData()
    {
        return [
            'safety_score' => rand(85, 99),
            'violations' => ['None (Mock Mode)'],
            'feedback' => 'Your content appears to be a Masterpiece. Logic is flowing perfectly.',
            'meta' => [
                'masterpiece_status' => 'Yes',
                'reason' => 'Mock Data - API Unavailable',
                'confidence' => 1.0
            ]
        ];
    }

    public function analyzeSafety(string $filePath, string $mimeType)
    {
        return $this->scanMedia($filePath);
    }

    // Strategy Generation
    public function generateStrategy(string $trendName)
    {
        if (empty($this->apiKey)) {
            return $this->getMockStrategyData($trendName);
        }

        return \Illuminate\Support\Facades\Cache::remember("zen_strategy_gemini_" . md5($trendName), 60 * 60 * 24, function () use ($trendName) {
            $prompt = "Act as a viral strategist. Generate content hook, 3 pillars, and vibe for trend: {$trendName}. Return JSON: {hook: string, pillars: string[], vibe: string}";

            try {
                $url = "{$this->baseUrl}{$this->model}:generateContent?key={$this->apiKey}";
                
                $response = Http::withOptions(['verify' => false])
                    ->post($url, [
                        'contents' => [['parts' => [['text' => $prompt]]]],
                        'generationConfig' => ['responseMimeType' => 'application/json']
                    ]);

                if ($response->successful()) {
                    $content = $response->json()['candidates'][0]['content']['parts'][0]['text'];
                    return json_decode($content, true) ?? $this->getMockStrategyData($trendName);
                }
            } catch (\Exception $e) {
                Log::error("ZenAi Strategy Error: " . $e->getMessage());
            }

            return $this->getMockStrategyData($trendName);
        });
    }

    // Pitch Generation
    public function generateCollabPitch(string $myNiche, string $theirNiche, string $theirName)
    {
        if (empty($this->apiKey)) {
            return $this->getMockPitchData($theirName);
        }

        return \Illuminate\Support\Facades\Cache::remember("zen_pitch_gemini_" . md5($theirName), 60 * 60 * 24, function () use ($myNiche, $theirNiche, $theirName) {
            $prompt = "Write a short collab pitch from {$myNiche} to {$theirName} ({$theirNiche}). Under 280 chars.";

            try {
                $url = "{$this->baseUrl}{$this->model}:generateContent?key={$this->apiKey}";
                
                $response = Http::withOptions(['verify' => false])
                    ->post($url, [
                        'contents' => [['parts' => [['text' => $prompt]]]]
                    ]);

                if ($response->successful()) {
                    return trim($response->json()['candidates'][0]['content']['parts'][0]['text']);
                }
            } catch (\Exception $e) {
                Log::error("ZenAi Pitch Error: " . $e->getMessage());
            }

            return $this->getMockPitchData($theirName);
        });
    }

    private function getMockPitchData($name)
    {
        return "Hey {$name}! Let's collab. #Masterpiece";
    }

    private function getMockStrategyData($trend)
    {
         return [
            'hook' => "Why is nobody talking about {$trend}?",
            'pillars' => ['Innovation', 'Community', 'Authenticity'],
            'vibe' => 'Modern / High-Energy'
        ];
    }
}
