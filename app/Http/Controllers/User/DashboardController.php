<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $tickets_count = Ticket::where('ticket_user_id', auth()->user()->id)->count();
        $pending_tickets_count = Ticket::whereHas('status', function ($query) {
            $query->where('status', 0);
            $query->where('ticket_user_id', auth()->user()->id);
        })->count();

        $solved_tickets_count = Ticket::whereHas('status', function ($query) {
            $query->where('status', 2);
            $query->where('ticket_user_id', auth()->user()->id);
        })->count();
        return view(
            'auth.user.dashboard',
            compact(
                'tickets_count',
                'pending_tickets_count',
                'solved_tickets_count'
            )
        );
    }
}
