<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Resource; 
use Illuminate\Support\Facades\Cache;
use App\Models\JournalEntry;
use App\Models\Checkin; // ✅ Add this so we can query check-ins

class QuoteController extends Controller
{
    // Show all quotes saved by the current user
    public function index()
    {
        $user = auth()->user();

        $userQuotes = $user->savedQuotes()
            ->withPivot('is_pinned')
            ->orderByDesc('pivot_is_pinned')
            ->orderBy('pivot_created_at', 'desc')
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

    // ✅ Dashboard
    public function dashboard()
    {
        $today = now()->toDateString();

        // Cache one random quote for the whole day
        $quote = Cache::remember("quote_of_the_day_{$today}", now()->addDay(), function () {
            return Quote::inRandomOrder()->first();
        });

        $savedQuoteIds = auth()->user()
            ->savedQuotes()
            ->pluck('quote_id');

        $featuredResources = Resource::where('is_featured', true)->take(3)->get();

        // ✅ Mood Tracker data
        $moodCounts = Checkin::where('user_id', auth()->id())
            ->where('date', '>=', now()->subDays(30))
            ->selectRaw('mood, COUNT(*) as count')
            ->groupBy('mood')
            ->pluck('count', 'mood');

        $periodCounts = Checkin::where('user_id', auth()->id())
            ->where('date', '>=', now()->subDays(30))
            ->selectRaw('period, COUNT(*) as count')
            ->groupBy('period')
            ->pluck('count', 'period');

        $recentCheckins = Checkin::where('user_id', auth()->id())
            ->latest('date')
            ->take(5)
            ->get();

        $moodTrend = Checkin::where('user_id', auth()->id())
            ->where('date', '>=', now()->subDays(30))
            ->selectRaw('date, AVG(mood) as avg')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn($row) => ['date' => $row->date, 'avg' => $row->avg]);

        return view('dashboard', compact(
            'quote',
            'savedQuoteIds',
            'featuredResources',
            'moodCounts',
            'periodCounts',
            'recentCheckins',
            'moodTrend'
        ));
    }

    // Redirect to journal creation with quote
    public function redirectToJournal(Request $request)
    {
        $quoteId = $request->quote_id;
        return redirect()->route('journal.create', ['quote_id' => $quoteId]);
    }

    public function showShareForm(Quote $quote)
    {
        return view('quotes.share_to_journal', compact('quote'));
    }

    public function shareToJournal(Request $request)
    {
        $request->validate([
            'quote_id' => 'required|exists:quotes,id',
            'reflection' => 'required|string|max:1000',
        ]);

        JournalEntry::create([
            'user_id'   => auth()->id(),
            'quote_id'  => $request->quote_id,
            'reflection'=> $request->reflection,
        ]);

        return redirect()->route('journals.index')->with('status', 'Quote shared to journal!');
    }
}
