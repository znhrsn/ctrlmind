<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\UserQuote;
use App\Models\Resource; // ✅ import Resource model
use Illuminate\Support\Facades\Cache;

class QuoteController extends Controller
{
    // Show all quotes saved by the current user
    public function index()
    {
        $quotes = UserQuote::where('user_id', auth()->id())
                           ->with('quote')
                           ->orderByDesc('pinned')
                           ->latest()
                           ->get();

        return view('quotes.index', compact('quotes'));
    }

    // Save/unsave toggle
    public function toggle(Request $request)
    {
        $request->validate([
            'quote_id' => 'required|exists:quotes,id',
        ]);

        $existing = UserQuote::where('user_id', auth()->id())
                             ->where('quote_id', $request->quote_id)
                             ->first();

        if ($existing) {
            $existing->delete();
            return redirect()->back()->with('success', 'Quote removed!');
        } else {
            UserQuote::create([
                'user_id' => auth()->id(),
                'quote_id' => $request->quote_id,
            ]);
            return redirect()->back()->with('success', 'Quote saved!');
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
    public function pin(Quote $quote)
    {
        $userQuote = UserQuote::where('user_id', auth()->id())
                              ->where('quote_id', $quote->id)
                              ->firstOrFail();

        if (!$userQuote->pinned) {
            $pinnedCount = UserQuote::where('user_id', auth()->id())
                                    ->where('pinned', true)
                                    ->count();
            if ($pinnedCount >= 3) {
                return redirect()->back()->with('error', 'You can only pin 3 quotes.');
            }
        }

        $userQuote->update(['pinned' => !$userQuote->pinned]);

        return redirect()->back()->with('success', $userQuote->pinned ? 'Pinned!' : 'Unpinned!');
    }

    // Dashboard
    public function dashboard()
    {
        // Quote of the Day (cached)
        $today = now()->toDateString();
        $quote = Cache::remember("quote_of_the_day_{$today}", now()->addDay(), function () {
            return Quote::inRandomOrder()->first();
        });

        // Saved quotes for current user
        $savedQuoteIds = UserQuote::where('user_id', auth()->id())->pluck('quote_id');

        // Featured resources
        $featuredResources = Resource::where('is_featured', true)->take(3)->get();

        return view('dashboard', compact('quote', 'savedQuoteIds', 'featuredResources'));
    }

    public function redirectToJournal(Request $request)
    {
        $quoteId = $request->quote_id;
        return redirect()->route('journal.create', ['quote_id' => $quoteId]);
    }
}
