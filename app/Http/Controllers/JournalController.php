<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\Quote;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    /* ---------------------------------------------------------
        CREATE ENTRY
    --------------------------------------------------------- */
    public function create(Request $request)
    {
        $quoteId = $request->quote_id;
        $quote = Quote::find($quoteId);

        return view('journal.create', compact('quote'));
    }

    /* ---------------------------------------------------------
        STORE ENTRY
    --------------------------------------------------------- */
    public function store(Request $request)
    {
        $request->validate([
            'reflection' => 'required|string',
        ]);

        JournalEntry::create([
            'user_id'    => auth()->id(),
            'reflection' => $request->reflection,
        ]);

        return redirect()
            ->route('journal.index')
            ->with('status', 'Entry saved successfully!');
    }

    /* ---------------------------------------------------------
        VIEW ACTIVE ENTRIES
    --------------------------------------------------------- */
    public function index()
    {
        $entries = JournalEntry::where('user_id', auth()->id())
            ->where('archived', false)
            ->with('quote')
            ->latest()
            ->get();

        return view('journal.index', compact('entries'));
    }

    /* ---------------------------------------------------------
        VIEW ARCHIVED ENTRIES
    --------------------------------------------------------- */
    public function showArchived()
    {
        // Auto-delete entries older than 30 days
        JournalEntry::where('archived', true)
            ->whereNotNull('archived_at')
            ->where('archived_at', '<', now()->subDays(30))
            ->delete();

        $entries = JournalEntry::where('user_id', auth()->id())
            ->where('archived', true)
            ->with('quote')
            ->latest()
            ->get();

        return view('journal.archived', compact('entries'));
    }

    /* ---------------------------------------------------------
        ARCHIVE ENTRY
    --------------------------------------------------------- */
    public function archiveEntry($id)
    {
        $entry = JournalEntry::where('user_id', auth()->id())
            ->findOrFail($id);

        $entry->archived = true;
        $entry->archived_at = now();
        $entry->save();

        return redirect()
            ->route('journal.index')
            ->with('status', 'Entry archived successfully!');
    }

    /* ---------------------------------------------------------
        RESTORE ENTRY
    --------------------------------------------------------- */
    public function restore($id)
    {
        $entry = JournalEntry::where('user_id', auth()->id())
            ->where('archived', true)
            ->findOrFail($id);

        $entry->archived = false;
        $entry->archived_at = null;
        $entry->save();

        return redirect()
            ->back()
            ->with('status', 'Entry restored successfully!');
    }

    public function restoreEntry($id)
    {
        $entry = JournalEntry::withTrashed()->findOrFail($id);
        $entry->restore();

        // Redirect straight to journal.index so the toast shows
        return redirect()->route('journal.index')
                        ->with('status', 'Entry restored successfully!');
    }

    /* ---------------------------------------------------------
        SHARE / UNSHARE ENTRY
    --------------------------------------------------------- */
    public function share($id)
    {
        $entry = JournalEntry::where('user_id', auth()->id())
            ->findOrFail($id);

        $entry->shared_with_consultant = !$entry->shared_with_consultant;
        $entry->save();

        return redirect()
            ->route('journal.index')
            ->with('status', 'Sharing preference updated.');
    }

    /* ---------------------------------------------------------
        EDIT (ONLY WITHIN 24 HOURS)
    --------------------------------------------------------- */
    public function edit($id)
    {
        $entry = JournalEntry::where('user_id', auth()->id())
            ->findOrFail($id);

        // Allow edit only if entry is less than 24 hours old
        if ($entry->created_at->lt(now()->subDay())) {
            return redirect()
                ->route('journal.index')
                ->with('status', 'You can only edit entries within 24 hours.');
        }

        return view('journal.edit', compact('entry'));
    }

    /* ---------------------------------------------------------
        UPDATE ENTRY
    --------------------------------------------------------- */
    public function update(Request $request, $id)
    {
        $entry = JournalEntry::where('user_id', auth()->id())
            ->findOrFail($id);

        // Validate reflection text
        $request->validate([
            'reflection' => 'required|string',
        ]);

        // Check if editing window expired
        if ($entry->created_at->lt(now()->subDay())) {
            return redirect()
                ->route('journal.index')
                ->with('status', 'Edit time has expired.');
        }

        // If no changes
        if ($entry->reflection === $request->reflection) {
            return redirect()
                ->route('journal.index')
                ->with('status', 'No changes were made.');
        }

        // Update
        $entry->reflection = $request->reflection;
        $entry->save();

        return redirect()
            ->route('journal.index')
            ->with('status', 'Journal entry updated successfully.');
    }
}
