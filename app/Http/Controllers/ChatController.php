<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class ChatController extends Controller
{
    public function index()
    {
        $consultant = User::find(auth()->user()->consultant_id);

        // Fetch messages between the logged-in user and their consultant
        $messages = Message::where(function ($query) use ($consultant) {
                $query->where('sender_id', auth()->id())
                      ->where('receiver_id', $consultant->id);
            })
            ->orWhere(function ($query) use ($consultant) {
                $query->where('sender_id', $consultant->id)
                      ->where('receiver_id', auth()->id());
            })
            ->orderBy('created_at')
            ->get();

        // If no messages yet, send a welcome message from consultant
        if ($messages->isEmpty() && $consultant) {
            Message::create([
                'sender_id'   => $consultant->id,  // consultant sends
                'receiver_id' => auth()->id(),     // user receives
                'content'     => 'Hi! I’m here if you need anything. How can I help today?',
            ]);

            $messages = Message::where(function ($query) use ($consultant) {
                    $query->where('sender_id', auth()->id())
                          ->where('receiver_id', $consultant->id);
                })
                ->orWhere(function ($query) use ($consultant) {
                    $query->where('sender_id', $consultant->id)
                          ->where('receiver_id', auth()->id());
                })
                ->orderBy('created_at')
                ->get();
        }

        return view('chat.index', compact('messages', 'consultant'));
    }

    public function store(Request $request)
    {
        $consultantId = auth()->user()->consultant_id;

        Message::create([
            'sender_id'   => auth()->id(),     // logged-in user sends
            'receiver_id' => $consultantId,    // consultant receives
            'content'     => $request->content,
        ]);

        return redirect()->back();
    }
}