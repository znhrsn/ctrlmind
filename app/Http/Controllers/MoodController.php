<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MoodLog;

class MoodController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'mood' => 'required|string|max:10',
        ]);

        MoodLog::create([
            'user_id' => auth()->id(),
            'mood'    => $request->mood,
        ]);

        return redirect()->back()->with('success', 'Mood logged successfully!');
    }
}
