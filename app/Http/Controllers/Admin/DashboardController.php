<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketCategory;

class DashboardController extends Controller
{
    public function index()
    {
        $tickets_count = Ticket::all()->count();
        $categories_count = TicketCategory::all()->count();
        $pending_tickets_count = Ticket::whereHas('status', function ($query) {
            $query->where('status', 0);
        })->count();

        $solved_tickets_count = Ticket::whereHas('status', function ($query) {
            $query->where('status', 2);
        })->count();
        return view(
            'auth.admin.dashboard',
            compact(
                'tickets_count',
                'categories_count',
                'pending_tickets_count',
                'solved_tickets_count'
            )
        );
    }
}
