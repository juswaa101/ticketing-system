<?php

namespace App\Observers;

use App\Mail\NotifyUser;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        $ticket = Ticket::findOrFail($comment->ticket_id);
        if ($ticket) {
            TicketLog::create([
                'ticket_id' => $comment->ticket_id,
                'ticket_action_user_id' => $comment->user_id,
                'action_made' => ' does comment to a issue/ticket: ' . $ticket->title
            ]);
        }
    }
}
