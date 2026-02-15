<?php

namespace App\Http\Controllers;

use App\Models\CourseMaterial;
use App\Services\ZenAiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    protected $ai;

    public function __construct(ZenAiService $ai)
    {
        $this->ai = $ai;
    }

    public function dashboard()
    {
        return view('exam.dashboard', [
            'materials' => CourseMaterial::where('user_id', auth()->id())->latest()->get()
        ]);
    }

    public function uploadMaterial(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,txt,doc,docx|max:10240', // 10MB max
        ]);

        $path = $request->file('file')->store('course_materials', 'local');
        
        // Simulating text extraction for now
        // In production, use Spatie/PdfToText or similar
        $extractedText = "Simulated extraction for " . $request->file('file')->getClientOriginalName(); 

        CourseMaterial::create([
            'user_id' => auth()->id(),
            'course_name' => $request->course_name,
            'file_path' => $path,
            'extracted_text' => $extractedText,
            'is_indexed' => true,
        ]);

        return back()->with('status', 'Material uploaded and indexed into Knowledge Vault.');
    }

    public function solve(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
        ]);

        // Retrieve all indexed materials for context
        // Optimally, use Vector Search here. For MVP, we concatenate recent text.
        $materials = CourseMaterial::where('user_id', auth()->id())
            ->where('is_indexed', true)
            ->latest()
            ->take(5)
            ->pluck('extracted_text')
            ->join("\n\n");

        $context = $materials ?: "No course material uploaded.";

        $result = $this->ai->solveWithGuardrails($request->question, $context);

        return response()->json($result);
    }
}
