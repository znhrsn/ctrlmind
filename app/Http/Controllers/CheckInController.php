<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckinController extends Controller
{
    public function start()
    {
        return view('checkin.start');
    }

    /**
     * Show calendar view with check-ins grouped by date.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $checkins = CheckIn::where('user_id', $userId)
            ->orderBy('date')
            ->get()
            ->groupBy(function ($item) {
                return $item->date->toDateString();
            });

        return view('checkin.calendar', [
            'checkinsByDate' => $checkins,
            'month' => $request->input('month', Carbon::now()->month),
            'year' => $request->input('year', Carbon::now()->year),
            'openDate' => $request->input('open_date'),
        ]);
    }

    /**
     * Store or update a check-in for the given date and period.
     */
    public function store(Request $request)
    {
        // If period isn't provided by the client, infer it from the current time
        if (! $request->has('period') || ! $request->filled('period')) {
            $request->merge(['period' => $this->currentPeriod()]);
        }

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'period' => ['required', 'in:Morning,Afternoon,Evening'],
            'mood' => ['nullable', 'integer', 'between:1,5'],
            'energy' => ['nullable', 'integer', 'between:1,5'],
            'focus' => ['nullable', 'integer', 'between:1,5'],
            'satisfaction' => ['nullable', 'integer', 'between:1,5'],
            'self_kindness' => ['nullable', 'integer', 'between:1,5'],
            'relaxation' => ['nullable', 'integer', 'between:1,5'],
            'note' => ['nullable', 'string', 'max:280'],
        ]);

        // Server-side: only allow creating/updating check-ins for today
        $submittedDate = Carbon::parse($validated['date'])->startOfDay();
        if (! $submittedDate->isSameDay(Carbon::today())) {
            return back()->withErrors(['date' => 'You may only submit a check-in for today.']);
        }

        $userId = Auth::id();

        $checkin = CheckIn::updateOrCreate(
            [
                'user_id' => $userId,
                'date' => Carbon::parse($validated['date'])->toDateString(),
                'period' => $validated['period'],
            ],
            [
                'mood' => $validated['mood'] ?? null,
                'energy' => $validated['energy'] ?? null,
                'focus' => $validated['focus'] ?? null,
                'satisfaction' => $validated['satisfaction'] ?? null,
                'self_kindness' => $validated['self_kindness'] ?? null,
                'relaxation' => $validated['relaxation'] ?? null,
                'note' => $validated['note'] ?? null,
            ]
        );

        return back()->with('success', 'Check-in saved.');
    }

    /**
     * Determine current period from server time.
     */
    protected function currentPeriod(): string
    {
        $hour = Carbon::now()->hour;

        // Morning: 5:00 - 11:59, Afternoon: 12:00 - 16:59, Evening: 17:00 - 4:59
        if ($hour >= 5 && $hour < 12) {
            return 'Morning';
        }

        if ($hour >= 12 && $hour < 17) {
            return 'Afternoon';
        }

        return 'Evening';
    }

    /**
     * Delete a check-in entry. Only the owner may delete.
     */
    public function destroy(CheckIn $checkin)
    {
        if ($checkin->user_id !== Auth::id()) {
            abort(403);
        }

        $checkin->delete();

        return back()->with('success', 'Check-in deleted.');
    }

    /**
     * Get mood distribution data for the user.
     */
    public function moodDistribution(Request $request)
    {
        $userId = Auth::id();
        $period = $request->input('period', '30'); // days

        $checkins = CheckIn::where('user_id', $userId)
            ->where('date', '>=', Carbon::now()->subDays($period))
            ->whereNotNull('mood')
            ->selectRaw('mood, COUNT(*) as count')
            ->groupBy('mood')
            ->orderBy('mood')
            ->get();

        return response()->json($checkins);
    }

    /**
     * Get mood trend data for the user.
     */
    public function moodTrend(Request $request)
    {
        $userId = Auth::id();
        $period = $request->input('period', '30'); // days

        $checkins = CheckIn::where('user_id', $userId)
            ->where('date', '>=', Carbon::now()->subDays($period))
            ->whereNotNull('mood')
            ->selectRaw('DATE(date) as date, AVG(mood) as average_mood')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($checkins);
    }
}
