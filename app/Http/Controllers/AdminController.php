<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Changelog;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        $changelogs = Changelog::latest()->get();

        return view('admin.dashboard', compact('users', 'changelogs'));
    }

    public function updateNote(Request $request, User $user)
    {
        $request->validate([
            'admin_notes' => 'nullable|string',
        ]);

        $user->update(['admin_notes' => $request->admin_notes]);

        return back()->with('status', 'Note updated successfully.');
    }

    public function storeChangelog(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'version' => 'nullable|string|max:50',
            'body' => 'required|string',
            'published' => 'nullable|boolean',
        ]);

        Changelog::create([
            'title' => $request->title,
            'version' => $request->version,
            'body' => $request->body,
            'published_at' => $request->published ? now() : null,
        ]);

        return back()->with('status', 'Changelog created successfully.');
    }
    
    public function deleteChangelog(Changelog $changelog)
    {
        $changelog->delete();
        return back()->with('status', 'Changelog deleted.');
    }
}
