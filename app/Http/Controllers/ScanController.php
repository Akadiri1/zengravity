<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        $scans = auth()->user()->scans()->latest()->get();
        return view('scans.index', compact('scans'));
    }

    public function create()
    {
        return view('scans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // Max 10MB
        ]);

        $path = $request->file('image')->store('scans', 'public');

        // Simulate AI Safety Check
        // Simulate AI Safety Check
        // Mocking logic: Fixed score for testing as requested
        $safety_score = 85;
        $violations = [];
        $ai_feedback = "Status: Safe. Content approved by ZenGravity AI.";

        // Randomize slightly for variety if needed, but keeping fixed for now
        // if ($safety_score < 80) { ... }

        $scan = auth()->user()->scans()->create([
            'media_type' => 'image',
            'file_path' => $path,
            'safety_score' => $safety_score,
            'violations' => $violations,
            'ai_feedback' => $ai_feedback,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect_url' => route('scans.show', $scan)
            ]);
        }

        return redirect()->route('scans.show', $scan);
    }

    public function show(Scan $scan)
    {
        // specific scan view
        // Ensure user owns the scan
        if ($scan->user_id !== auth()->id()) {
            abort(403);
        }
        return view('scans.show', compact('scan'));
    }

    public function destroy(Scan $scan)
    {
        if ($scan->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete file from storage
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($scan->file_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($scan->file_path);
        }

        $scan->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Scan deleted successfully']);
        }

        return redirect()->route('app')->with('status', 'Scan deleted from ledger.');
    }
}
