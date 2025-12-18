<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'suggestion' => 'required|string|min:5|max:1000',
        ]);

        Suggestion::create([
            'content' => $request->suggestion,
        ]);

        // Redirect back with a success toast/status
        return back()->with('status', 'Thank you! Your anonymous suggestion has been sent.');
    }
}