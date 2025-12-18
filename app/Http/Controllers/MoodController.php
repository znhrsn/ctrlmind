<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckIn;
use Illuminate\Support\Facades\Auth;

class MoodController extends Controller
{
    // Save mood
    public function store(Request $request)
    {
        $request->validate([
            'mood' => 'required|string|max:10',
        ]);

        CheckIn::create([
            'user_id' => Auth::id(),
            'mood'    => $request->mood,
            'date'    => $request->date,
            'period'  => $request->period,
            'energy' => $request->energy,
            'focus' => $request->focus,
            'satisfaction' => $request->satisfaction,
            'self_kindness' => $request->self_kindness,
            'relaxation' => $request->relaxation,
            'note' => $request->note,
        ]);

        return redirect()->back()->with('success', 'Mood logged successfully!');
    }

    // Fetch check-ins grouped by date
    public function index()
    {
        $year = now()->year; // or get from request
        $month = now()->month; // or get from request

        $checkins = CheckIn::where('user_id', Auth::id())
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        $checkinsByDate = $checkins->groupBy('date');

        return view('checkins.index', compact('checkinsByDate'));
    }
}

