<?php

namespace App\Http\Controllers;

use App\Models\Changelog;
use Illuminate\Http\Request;

class ChangelogController extends Controller
{
    public function index()
    {
        $updates = Changelog::whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->get();

        return view('updates.index', compact('updates'));
    }
}
