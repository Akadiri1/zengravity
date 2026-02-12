<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\CollabController;

class VibeMatchTest extends TestCase
{
    /**
     * Test that exact niche matches return a high vibe score (92-99).
     */
    public function test_exact_match_returns_high_score(): void
    {
        $controller = new CollabController();
        $score = $controller->calculateVibeScore('Tech', 'Tech');

        $this->assertGreaterThanOrEqual(92, $score);
        $this->assertLessThanOrEqual(99, $score);
    }

    /**
     * Test that different niches return a moderate vibe score (65-88).
     */
    public function test_partial_match_returns_moderate_score(): void
    {
        $controller = new CollabController();
        $score = $controller->calculateVibeScore('Tech', 'Fashion');

        $this->assertGreaterThanOrEqual(65, $score);
        $this->assertLessThanOrEqual(88, $score);
    }

    /**
     * Test case insensitivity.
     */
    public function test_case_insensitive_match(): void
    {
        $controller = new CollabController();
        $score = $controller->calculateVibeScore('tech', 'TECH');

        $this->assertGreaterThanOrEqual(92, $score);
        $this->assertLessThanOrEqual(99, $score);
    }
}
