<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Resource; 
use Illuminate\Support\Facades\Cache;

class QuoteController extends Controller
{
    // Show all quotes saved by the current user
    public function index()
    {
        $user = auth()->user();

        // Use relationship instead of raw UserQuote
        $userQuotes = $user->savedQuotes()
            ->withPivot('is_pinned')
            ->orderByDesc('pivot_is_pinned')   // pinned first
            ->orderBy('pivot_created_at', 'desc') // then newest saved
            ->get();

        return view('quotes.index', compact('userQuotes'));
    }

    // Save/unsave toggle
    public function toggle(Request $request)
    {
        $quoteId = $request->input('quote_id');
        $user = auth()->user();

        if ($user->savedQuotes()->where('quote_id', $quoteId)->exists()) {
            $user->savedQuotes()->detach($quoteId);
            return redirect()->back()->with('status', 'Quote Unsaved');
        } else {
            $user->savedQuotes()->attach($quoteId);
            return redirect()->back()->with('status', 'Quote Saved');
        }
    }

    // Admin uploads a new quote
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'author' => 'nullable|string',
        ]);

        Quote::create([
            'text' => $request->text,
            'author' => $request->author,
        ]);

        return redirect()->back()->with('success', 'Quote added!');
    }

    // Pin/unpin quotes (max 3 per user)
    public function pin(Request $request)
    {
        $quoteId = $request->input('quote_id');
        $user = auth()->user();

        $pinnedCount = $user->savedQuotes()->wherePivot('is_pinned', true)->count();
        $alreadyPinned = $user->savedQuotes()
            ->wherePivot('is_pinned', true)
            ->where('quote_id', $quoteId)
            ->exists();

        if ($alreadyPinned) {
            $user->savedQuotes()->updateExistingPivot($quoteId, ['is_pinned' => false]);
            return redirect()->back()->with('status', 'Quote Unpinned');
        }

        if ($pinnedCount >= 3) {
            return redirect()->back()->with('status', 'You can only pin 3 quotes. Unpin one first.');
        }

        $user->savedQuotes()->updateExistingPivot($quoteId, ['is_pinned' => true]);
        return redirect()->back()->with('status', 'Quote Pinned');
    }

    // Dashboard
    public function dashboard()
    {
        $today = now()->toDateString();

        // Cache one random quote for the whole day
        $quote = Cache::remember("quote_of_the_day_{$today}", now()->addDay(), function () {
            return Quote::inRandomOrder()->first();
        });

        // ✅ Define savedQuoteIds properly
        $savedQuoteIds = auth()->user()
            ->savedQuotes()   // relationship from User model
            ->pluck('quote_id'); // or ->pluck('quotes.id') depending on your schema

        // Featured resources
        $featuredResources = Resource::where('is_featured', true)->take(3)->get();

        // Mood tracker: last 30 days
        $user = auth()->user();
        $rangeDays = 30;
        $start = now()->subDays($rangeDays - 1)->startOfDay();

        $checkins = \App\Models\CheckIn::where('user_id', $user->id)
            ->whereBetween('date', [$start->toDateString(), now()->toDateString()])
            ->orderBy('date')
            ->get()
            ->groupBy('date');

        $moodTrend = [];
        for ($d = $start->copy(); $d->lte(now()); $d->addDay()) {
            $dateKey = $d->toDateString();
            $items = $checkins[$dateKey] ?? collect();
            if ($items->count()) {
                $avg = (int) round($items->avg('mood'));
            } else {
                $avg = null; // no data
            }
            $moodTrend[] = ['date' => $dateKey, 'avg' => $avg];
        }

        // Counts by mood value in the range
        $moodCounts = \App\Models\CheckIn::where('user_id', $user->id)
            ->whereBetween('date', [$start->toDateString(), now()->toDateString()])
            ->whereNotNull('mood')
            ->get()
            ->groupBy('mood')
            ->map->count();

        // Counts by period (morning/afternoon/evening)
        $periodCounts = \App\Models\CheckIn::where('user_id', $user->id)
            ->whereBetween('date', [$start->toDateString(), now()->toDateString()])
            ->get()
            ->groupBy('period')
            ->map->count();

        // Recent checkins: pick the latest entry per date (prefer Evening if present), up to 7 dates
        $recentDates = \App\Models\CheckIn::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->unique()
            ->take(7)
            ->values();

        $recentCheckins = collect();
        foreach ($recentDates as $d) {
            $entry = \App\Models\CheckIn::where('user_id', $user->id)
                ->where('date', $d)
                ->orderByRaw("case when period='Evening' then 1 when period='Morning' then 2 else 3 end")
                ->orderBy('id', 'desc')
                ->first();
            if ($entry) {
                $recentCheckins->push($entry);
            }
            if ($recentCheckins->count() >= 7) break;
        }

        return view('dashboard', compact('quote', 'savedQuoteIds', 'featuredResources', 'moodTrend', 'moodCounts', 'periodCounts', 'recentCheckins'));
    }

    // Redirect to journal creation with quote
    public function redirectToJournal(Request $request)
    {
        $quoteId = $request->quote_id;
        return redirect()->route('journal.create', ['quote_id' => $quoteId]);
    }
}