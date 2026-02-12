<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ZenAiService;
use App\Models\Collab;
use Illuminate\Support\Facades\Auth;

class CollabController extends Controller
{
    public function findMatches(ZenAiService $zenAi)
    {
        // Get the current user's profile
        $userProfile = DB::table('collabs')->where('user_id', Auth::id())->first();

        // If no profile exists, redirect to dashboard with error
        if (!$userProfile) {
            return redirect()->route('app')->with('error', 'Please complete your Collab Profile first to find matches!');
        }

        // Search for other creators in the same niche, excluding the current user
        // We join users table to ensure we have names for the view
        $matches = DB::table('collabs')
            ->join('users', 'collabs.user_id', '=', 'users.id')
            ->select('collabs.*', 'users.name', 'users.email')
            ->where('collabs.user_id', '!=', Auth::id())
            ->where('collabs.niche', 'LIKE', '%' . $userProfile->niche . '%')
            ->limit(6)
            ->get()
            ->map(function ($match) use ($userProfile, $zenAi) {
                // Attach a dynamic vibe score for the UI
                $match->vibe_score = $this->calculateVibeScore($userProfile->niche, $match->niche);
                // Attach AI Pitch
                $match->ai_pitch = $zenAi->generateCollabPitch($userProfile->niche, $match->niche, $match->name);
                return $match;
            });

        return view('collab.results', compact('matches', 'userProfile'));
    }

    /**
     * Store or update the user's influencer profile.
     */
    public function storeProfile(Request $request)
    {
        $request->validate([
            'niche' => 'required|string|max:255',
            'bio_summary' => 'required|string|max:1000',
        ]);

        DB::table('collabs')->updateOrInsert(
            ['user_id' => Auth::id()],
            [
                'niche' => $request->niche,
                'bio_summary' => $request->bio_summary,
                'updated_at' => now(),
                'created_at' => now(), // Note: updateOrInsert doesn't auto-manage created_at on update, but fine for now
            ]
        );

        return redirect()->route('collab.matches')->with('status', 'Masterpiece Profile Updated! Finding your matches...');
    }

    /**
     * Mock function to simulate AI "Vibe" matching.
     */
    public function calculateVibeScore($userNiche, $matchNiche)
    {
        // Simple logic: if niches match exactly, high score. Otherwise, moderate.
        if (strtolower($userNiche) === strtolower($matchNiche)) {
            return rand(92, 99);
        }
        
        return rand(65, 88);
    }
}
