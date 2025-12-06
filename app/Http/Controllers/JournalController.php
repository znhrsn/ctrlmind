<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\Quote;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    // Show the "create journal entry" form with a quote (optional)
    public function create(Request $request)
    {
        $quote = null;

        if ($request->has('quote_id')) {
            $quote = Quote::findOrFail($request->quote_id);
        }

        return view('journal.create', compact('quote'));
    }

    // Store a journal entry (either free-form or tied to a quote)
    public function store(Request $request)
    {
        $request->validate([
            'reflection' => 'required|string|max:500',
            'quote_id'   => 'nullable|exists:quotes,id',
        ]);

        JournalEntry::create([
            'user_id'   => auth()->id(),
            'quote_id'  => $request->quote_id, // can be null
            'reflection'=> $request->reflection,
        ]);

        return redirect()->route('journal.index')->with('success', 'Journal entry saved!');
    }

    // Show all journal entries
    public function index()
    {
        $entries = JournalEntry::where('user_id', auth()->id())
                               ->with('quote')
                               ->latest()
                               ->get();

        return view('journal.index', compact('entries'));
    }
    // Archive (soft delete)
    public function archive($id)
    {
        $entry = JournalEntry::where('user_id', auth()->id())->findOrFail($id);
        $entry->delete(); // soft delete
        return redirect()->route('journal.index')->with('success', 'Entry archived.');
    }

    public function restore($id)
    {
        $entry = JournalEntry::onlyTrashed()
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $entry->restore();
        return redirect()->route('journal.archived')->with('success', 'Entry restored.');
    }

    public function archived()
    {
        $entries = JournalEntry::onlyTrashed()
            ->where('user_id', auth()->id())
            ->with('quote')
            ->latest()
            ->get();

        return view('journal.archived', compact('entries'));
    }
}