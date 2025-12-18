<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class JournalSharedNotification extends Notification
{
    use Queueable;

    protected $journal;

    public function __construct($journal)
    {
        $this->journal = $journal;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Shared Journal',
            'message' => $this->journal->user->name . ' shared a journal entry: "' . $this->journal->title . '"',
            // This takes the consultant straight to the shared journals list
            'url' => route('consultants.shared_journals'), 
        ];
    }
}