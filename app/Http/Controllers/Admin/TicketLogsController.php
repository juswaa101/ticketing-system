<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketLog;
use Illuminate\Http\Request;

class TicketLogsController extends Controller
{
    public function index()
    {
        return view('auth.admin.dashboard');
    }

    public function renderLogs()
    {
        return TicketLog::with('ticket', 'user')->latest()->get();
    }
}
