<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ZenAiService;

class HiveController extends Controller
{
    /**
     * Display a list of trending hives/niches.
     */
    public function index(ZenAiService $zenAi)
    {
        // Mocking some trend data for now
        $baseHives = [
            ['name' => 'West Africa Urban Farming', 'platform' => 'TikTok', 'surge' => 145, 'competition' => 'Low'],
            ['name' => 'Benin City AI Artists', 'platform' => 'Instagram', 'surge' => 89, 'competition' => 'Very Low'],
            ['name' => 'Eco-Friendly Tech Repair', 'platform' => 'X', 'surge' => 210, 'competition' => 'Medium'],
            ['name' => '3D Printing for Heritage', 'platform' => 'Pinterest', 'surge' => 67, 'competition' => 'Low'],
            ['name' => 'Afro-Futurist Architecture', 'platform' => 'YouTube', 'surge' => 320, 'competition' => 'High'],
        ];

        // Enrich with AI Strategy
        $hives = collect($baseHives)->map(function ($hive) use ($zenAi) {
            $strategy = $zenAi->generateStrategy($hive['name']);
            return array_merge($hive, ['strategy' => $strategy]);
        });

        return view('hive.index', compact('hives'));
    }
}
