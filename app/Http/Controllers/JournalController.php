<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\Quote;
use Illuminate\Http\Request;
use App\Notifications\JournalSharedNotification;
use Illuminate\Support\Facades\Log;

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

    /* ---------------------------------------------------------
        SHARE ENTRY & NOTIFY CONSULTANT
    --------------------------------------------------------- */
    public function share($id)
    {
        // 1. Find the entry belonging to the user
        $entry = JournalEntry::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // 2. Toggle the sharing status
        $entry->shared_with_consultant = !$entry->shared_with_consultant;
        $entry->save();

        // 3. Notify Consultant only if being shared (not unshared)
        if ($entry->shared_with_consultant) {
            $consultant = auth()->user()->consultant;

            if ($consultant) {
                try {
                    $consultant->notify(new JournalSharedNotification($entry));
                    Log::info('Journal share notification sent to ' . $consultant->email);
                } catch (\Exception $e) {
                    Log::error('Journal notification failed: ' . $e->getMessage());
                }
            }
        }

        return back()->with('status', $entry->shared_with_consultant
            ? 'Journal shared with your consultant.'
            : 'Journal unshared.');
    }

    /* ---------------------------------------------------------
        EDIT (ONLY WITHIN 24 HOURS)
    --------------------------------------------------------- */
    public function edit($id)
    {
        $entry = JournalEntry::where('user_id', auth()->id())
            ->findOrFail($id);

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

        $request->validate([
            'reflection' => 'required|string',
        ]);

        if ($entry->created_at->lt(now()->subDay())) {
            return redirect()
                ->route('journal.index')
                ->with('status', 'Edit time has expired.');
        }

        if ($entry->reflection === $request->reflection) {
            return redirect()
                ->route('journal.index')
                ->with('status', 'No changes were made.');
        }

        $entry->reflection = $request->reflection;
        $entry->save();

        return redirect()
            ->route('journal.index')
            ->with('status', 'Journal entry updated successfully.');
    }
}