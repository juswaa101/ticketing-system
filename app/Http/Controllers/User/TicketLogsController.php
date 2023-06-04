<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TicketLog;
use Illuminate\Http\Request;

class TicketLogsController extends Controller
{
    private $departments = [];

    public function index()
    {
        return view('auth.user.dashboard');
    }

    public function renderLogs()
    {
        // push role of current user
        foreach (auth()->user()->roles as $role) {
            array_push($this->departments, $role->id);
        }

        $departments = $this->departments;

        return TicketLog::whereHas('ticket', function ($q) use ($departments) {
            $q->whereIn('ticket_department_id', $departments);
            $q->orWhere('ticket_user_id', auth()->user()->id);
        })->with('ticket', 'user')->latest()->get();
    }
}
