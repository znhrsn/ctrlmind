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
        // Assumes 'clients' relation is defined in User model: 
        // public function clients() { return $this->hasMany(User::class, 'consultant_id'); }
        $clients = auth()->user()->clients; 
        return view('consultants.dashboard', compact('clients'));
    }

    public function chat(User $user)
    {
        $consultant = auth()->user();

        // Fetch all messages between consultant and this specific client
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
        $request->validate(['content' => 'required']);

        Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $user->id,
            'content'     => $request->content,
        ]);

        return redirect()->back()->with('success', 'Message sent.');
    }
    
    /**
     * View shared journals from clients
     */
    public function sharedJournals()
    {
        $consultantId = auth()->id();

        // Fetch journals where shared_with_consultant is true 
        // AND the user belongs to THIS consultant
        $journals = JournalEntry::with(['user', 'quote']) 
            ->where('shared_with_consultant', true)
            ->whereHas('user', function ($q) use ($consultantId) {
                $q->where('consultant_id', $consultantId);
            })
            ->latest()
            ->get();

        return view('consultants.shared_journals', compact('journals'));
    }
}