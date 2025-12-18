<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewClientAssigned extends Notification
{
    use Queueable;

    protected $user; // This holds the new client data

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database']; // This tells Laravel to save to the 'notifications' table
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New Client Assigned',
            'message' => $this->user->name . ' has been assigned to you.',
            'url' => route('consultant.notifications.index'),
        ];
    }
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Client Assigned',
            'message' => $this->user->name . ' has been assigned to you.',
            // Ensure this matches the ->name() in web.php exactly
            'url' => route('consultant.notifications.index'), 
        ];
    }
}