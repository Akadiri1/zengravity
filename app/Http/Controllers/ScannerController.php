<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scan;
use Illuminate\Support\Facades\Auth;
use App\Services\ZenAiService;

class ScannerController extends Controller
{
    protected $zenAi;

    public function __construct(ZenAiService $zenAi)
    {
        $this->zenAi = $zenAi;
    }

    public function store(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'media' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,mp4,mov,avi,mkv,webm,flv,wmv,mp3,wav,ogg,flac,aac,wma,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,7z',
                'max:15728640', // 15GB in KB
            ],
        ], [
            'media.required' => 'Please upload a file to scan.',
            'media.file' => 'The uploaded item must be a valid file.',
            'media.mimes' => 'This file type is not supported. Please upload an image, video, audio, or document file.',
            'media.max' => 'File size exceeds the 15GB limit.',
        ]);

        try {
            $file = $request->file('media');
            $path = $file->store('scans', 'public');
            $mimeType = $file->getMimeType();

            // Use the ZenAi Bridge (Constructor Injected)
            $analysis = $this->zenAi->analyzeSafety($path, $mimeType);

            $scan = Scan::create([
                'user_id' => Auth::id(),
                'file_path' => $path,
                'safety_score' => $analysis['safety_score'],
                'violations' => $analysis['violations'],
                'ai_feedback' => $analysis['feedback'] ?? 'Analysis complete.',
                'status' => 'completed',
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ghost Scan Complete',
                    'scan' => $scan,
                    'redirect' => route('scan.show', $scan->id)
                ]);
            }

            return redirect()->route('scan.show', $scan->id)->with('status', 'Ghost Scan Complete: Logged in Ledger.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e; // Let Laravel handle validation exceptions normally
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Scan failed: ' . $e->getMessage(),
                ], 500);
            }

            return back()->withErrors(['media' => 'Scan failed: ' . $e->getMessage()]);
        }
    }

    public function show(Scan $scan)
    {
        // Ensure user owns the scan
        if ($scan->user_id !== Auth::id()) { abort(403); }

        return view('scans.show', compact('scan'));
    }
}
