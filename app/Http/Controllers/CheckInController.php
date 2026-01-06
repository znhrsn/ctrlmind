<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkin;

class CheckinController extends Controller
{
    // Show all check-ins for the current user
    public function index()
    {
        $checkinsByDate = Checkin::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('date');

        return view('checkins.index', compact('checkinsByDate'));
    }

    // Optional: start a new check-in
    public function start()
    {
        return view('checkins.start');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date'           => 'required|date',
            'period'         => 'required|in:Morning,Evening,morning,evening',
            'mood'           => 'required|integer|min:1|max:5',
            'note'           => 'nullable|string',
            // Survey Scales
            'energy'         => 'nullable|integer|min:1|max:5',
            'focus'          => 'nullable|integer|min:1|max:5',
            'satisfaction'   => 'nullable|integer|min:1|max:5',
            'self_kindness'  => 'nullable|integer|min:1|max:5',
            'relaxation'     => 'nullable|integer|min:1|max:5',
        ]);

        // Normalize period to lowercase to match database enum
        $validated['period'] = strtolower($validated['period']);

        // Find existing entry for that day/period or create a new one
        \App\Models\Checkin::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'date'    => $validated['date'],
                'period'  => $validated['period'],
            ],
            $validated
        );

        return back()->with('success', 'Check-in saved successfully!');
    }
}
