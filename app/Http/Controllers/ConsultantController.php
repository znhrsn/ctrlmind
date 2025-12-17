<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;

class ConsultantController extends Controller
{
    public function dashboard()
    {
        $clients = auth()->user()->clients; // assumes relation defined in User model
        return view('consultants.dashboard', compact('clients'));
    }

    public function chat(User $user)
    {
        $consultant = auth()->user();

        // Fetch all messages between consultant and this user
        $messages = Message::where(function ($query) use ($user, $consultant) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $consultant->id);
            })
            ->orWhere(function ($query) use ($user, $consultant) {
                $query->where('sender_id', $consultant->id)
                      ->where('receiver_id', $user->id);
            })
            ->orderBy('created_at')
            ->get();

        return view('consultants.chat', compact('messages', 'user'));
    }

    public function reply(Request $request, User $user)
    {
        $consultant = auth()->user();

        Message::create([
            'sender_id'   => $consultant->id,
            'receiver_id' => $user->id,
            'content'     => $request->content,
        ]);

        return redirect()->back()->with('success', 'Message sent.');
    }
    
    public function notifications()
    {
        // TODO: fetch unread messages or journal shares
        return view('consultants.notifications');
    }

    public function sharedJournals(Request $request)
    {
        $consultant = auth()->user();

        $q = trim($request->input('q', ''));
        $selectedUserId = $request->input('user_id');

        // Find user IDs that have at least one journal entry shared with a consultant
        $sharedUserIds = \App\Models\JournalEntry::where('shared_with_consultant', true)
            ->pluck('user_id')
            ->unique()
            ->values()
            ->all();

        // Base user query limited to those who have shared journals
        $usersQuery = \App\Models\User::whereIn('id', $sharedUserIds);

        if ($q !== '') {
            $qLower = mb_strtolower($q);
            $usersQuery->whereRaw('LOWER(name) LIKE ?', ["%{$qLower}%"]);
        }

        $users = $usersQuery->orderBy('name')->paginate(20)->withQueryString();

        // Precompute counts and last shared date per user
        $stats = \App\Models\JournalEntry::where('shared_with_consultant', true)
            ->selectRaw('user_id, COUNT(*) as total, MAX(created_at) as last_shared')
            ->groupBy('user_id')
            ->pluck('total', 'user_id');

        $lastShared = \App\Models\JournalEntry::where('shared_with_consultant', true)
            ->selectRaw('user_id, MAX(created_at) as last_shared')
            ->groupBy('user_id')
            ->pluck('last_shared', 'user_id');

        $entries = collect();
        if ($selectedUserId) {
            $entries = \App\Models\JournalEntry::where('user_id', $selectedUserId)
                ->where('shared_with_consultant', true)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        return view('consultants.shared-journals', compact('users', 'stats', 'lastShared', 'entries', 'q', 'selectedUserId'));
    }
}
