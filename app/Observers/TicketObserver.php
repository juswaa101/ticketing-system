<?php

namespace App\Observers;

use App\Mail\NotifyUser;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        TicketLog::create([
            'ticket_id' => $ticket->id,
            'ticket_action_user_id' => $ticket->ticket_user_id,
            'action_made' => ' has created a issue/ticket: ' . $ticket->title
        ]);
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        TicketLog::create([
            'ticket_id' => $ticket->id,
            'ticket_action_user_id' => auth()->guard()->user()->id,
            'action_made' => ' has updated the issue/ticket: ' . $ticket->title
        ]);
    }
}
