<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\JournalEntry;

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

    public function sharedJournals()
    {
        $consultantId = auth()->id();

        $journals = JournalEntry::with(['user', 'quote']) // eager-load to show quote/user
            ->where('shared_with_consultant', true)
            ->whereHas('user', function ($q) use ($consultantId) {
                $q->where('consultant_id', $consultantId);
            })
            ->latest()
            ->get();

        return view('consultants.shared_journals', compact('journals'));
    }
}
