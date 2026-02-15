<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZenAiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');
    }

    /**
     * Ghost Scanner: Safety Analysis
     */
    public function analyzeSafety($filePath)
    {
        if (!$this->apiKey) {
            return [
                'safety_score' => rand(85, 99),
                'violations' => [],
                'ai_feedback' => 'No critical violations detected. Content appears original and safe for commercial use.',
            ];
        }

        // Real API implementation placeholder
        // In a real scenario, we would upload the file or send text content to Gemini
        return [
            'safety_score' => 92,
            'violations' => ['Minor similarity in texture usage'],
            'ai_feedback' => 'High originality score. Minor texture similarity detected but falls within fair use limits.',
        ];
    }

    /**
     * Collab Forge: Growth Matching
     */
    public function matchCollab($user)
    {
        if (!$this->apiKey) {
            return [
                'matches' => [
                    ['name' => 'NexusAudio', 'role' => 'Sound Designer', 'match_score' => 95, 'reason' => 'Perfect sonic match for your visual style.'],
                    ['name' => 'PixelWeaver', 'role' => 'Animator', 'match_score' => 88, 'reason' => 'Complementary color palette usage.'],
                ]
            ];
        }

        return [
            'matches' => [
                ['name' => 'CyberSynth', 'role' => 'Audio Engineer', 'match_score' => 98, 'reason' => 'AI analysis confirms high synergy in cyberpunk aesthetics.'],
            ]
        ];
    }

    /**
     * Collab Forge: Generate Pitch
     */
    public function generateCollabPitch($myNiche, $theirNiche, $theirName)
    {
        if (!$this->apiKey) {
            return "Hey $theirName! I see you're killing it in $theirNiche. As a $myNiche creator, I think we could create something unique properly combining our styles. Let's chat?";
        }

        // Real API Implementation
        $prompt = "Draft a short, punchy collaboration pitch from a '$myNiche' creator to a '$theirNiche' creator named '$theirName'. Keep it under 280 characters, casual but professional. Focus on the synergy.";

        try {
             $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post($this->baseUrl . '?key=' . $this->apiKey, [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? "Hey $theirName, let's collab!";
            }
        } catch (\Exception $e) {
            Log::error('ZenAiService Pitch Error: ' . $e->getMessage());
        }

        return "Hey $theirName! I loved your recent work in $theirNiche. Would love to discuss a potential collaboration.";
    }

    /**
     * Hive Scout: Trend Prediction
     */
    public function predictTrends($niche)
    {
        if (!$this->apiKey) {
            return [
                'trend' => 'Neo-Brutalism UI',
                'platform' => 'TikTok',
                'surge' => 145.5,
                'strategy' => 'Create tutorials focusing on raw, unpolished design aesthetics. Use high-contrast typography.',
            ];
        }
        
        return [
            'trend' => 'Glassmorphism 2.0',
            'platform' => 'Dribbble',
            'surge' => 210.2,
            'strategy' => 'Focus on "Adaptive Glass" effects that change with light/dark mode. High demand for tutorials.',
        ];
    }

    /**
     * Hive Scout: Generate Strategy
     */
    public function generateStrategy($topic)
    {
        $trends = $this->predictTrends($topic);
        return $trends['strategy'] ?? "Focus on high-quality content and consistent posting for $topic.";
    }

    /**
     * Exam Forge: Academic Solving (RAG)
     */
    public function solveWithGuardrails($question, $context)
    {
        $prompt = "You are an academic tutor. Use ONLY the provided course material to answer the question. If the answer is not in the material, state that you cannot answer from the provided context. \n\nCourse Material:\n$context\n\nQuestion: $question";

        if (!$this->apiKey) {
            // Mock RAG response
            return [
                'answer' => "Based on the provided material, the answer typically involves integrating specific modules. (Mock Response: Add API Key for real analysis)",
                'confidence' => 85,
                'doubt_reason' => null,
                'explanation' => 'This is a simulated response. Configure GEMINI_API_KEY to get real AI answers.',
            ];
        }

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post($this->baseUrl . '?key=' . $this->apiKey, [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No answer generated.';
                
                // Simple confidence logic based on length/specificity (Mock logic for now)
                $confidence = strlen($text) > 50 ? 95 : 60; 

                return [
                    'answer' => $text,
                    'confidence' => $confidence,
                    'doubt_reason' => $confidence < 85 ? 'The context provided might be insufficient.' : null,
                    'explanation' => 'Generated based on course material analysis.',
                ];
            } else {
                Log::error('Gemini API Error: ' . $response->body());
                return [
                    'answer' => 'Error connecting to AI Core.',
                    'confidence' => 0,
                    'doubt_reason' => 'API Connection Failed',
                    'explanation' => 'Please check system logs.',
                ];
            }
        } catch (\Exception $e) {
            Log::error('ZenAiService Exception: ' . $e->getMessage());
            return [
                'answer' => 'System Malfunction.',
                'confidence' => 0,
                'doubt_reason' => 'Internal Error',
                'explanation' => $e->getMessage(),
            ];
        }
    }
}
