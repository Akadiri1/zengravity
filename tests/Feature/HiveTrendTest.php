<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Services\ZenAiService;
use Mockery;

class HiveTrendTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the hive index page loads with data.
     */
    public function test_hive_page_loads_with_trend_data(): void
    {
        // Mock ZenAiService to avoid external calls
        $mockZenAi = Mockery::mock(ZenAiService::class);
        $mockZenAi->shouldReceive('generateStrategy')
            ->andReturn([
                'hook' => 'Test Hook', 
                'pillars' => ['Test Pillar'], 
                'vibe' => 'Test Vibe'
            ]);

        $this->app->instance(ZenAiService::class, $mockZenAi);

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('hive.index'));

        $response->assertStatus(200);
        $response->assertViewIs('hive.index');
        $response->assertViewHas('hives');

        // Check data structure of the first item
        $hives = $response->viewData('hives');
        $this->assertIsIterable($hives);
        $firstHive = $hives->first();
        
        $this->assertArrayHasKey('name', $firstHive);
        $this->assertArrayHasKey('strategy', $firstHive);
        $this->assertEquals('Test Hook', $firstHive['strategy']['hook']);
    }

    /**
     * Test guest cannot access hive.
     */
    public function test_guest_cannot_access_hive(): void
    {
        $response = $this->get(route('hive.index'));

        $response->assertRedirect(route('login'));
    }
}
