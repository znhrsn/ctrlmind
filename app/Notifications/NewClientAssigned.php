<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;

class NewClientAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public User $client) {}

    public function via($notifiable): array
    {
        return ['database']; // store in notifications table
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'New client assigned',
            'message' => "{$this->client->name} has been assigned to you.",
            'client_id' => $this->client->id,
            'client_name' => $this->client->name,
            'client_email' => $this->client->email,
        ];
    }
}