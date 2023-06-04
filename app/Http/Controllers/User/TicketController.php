<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    private $departments = [];

    use ResponseHelper;

    public function fetchTickets()
    {
        // push role of current user
        foreach (auth()->user()->roles as $role) {
            array_push($this->departments, $role->id);
        }

        // check if ticket is in department
        $tickets = Ticket::whereHas('owner', function ($query) {
            $query->where('ticket_user_id', auth()->user()->id);
            $query->orWhereIn('ticket_department_id', $this->departments);
        })->with('status', 'category', 'department', 'owner')->get();

        return $tickets;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.user.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string'],
            'message' => ['required', 'string', 'max:255'],
            'department' => ['required', 'integer'],
            'category' => ['required', 'integer'],
            'priority' => ['required', 'integer']
        ]);

        Ticket::create([
            'ticket_user_id' => auth()->user()->id,
            'ticket_status_id' => 1,
            'ticket_category_id' => $request->category,
            'ticket_department_id' => $request->department,
            'title' => $request->title,
            'message' => $request->message,
            'priority' => $request->priority,
        ]);

        return $this->success([], 'Ticket added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::with('status', 'category', 'owner', 'department', 'comments', 'logs')
            ->findOrFail($id);
        return $this->success($ticket, 'Ticket Found');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ticket = Ticket::with('status', 'category', 'owner', 'department')
            ->findOrFail($id);
        return $this->success($ticket, 'Ticket Found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $this->validate($request, [
            'title' => ['required', 'string'],
            'message' => ['required', 'string', 'max:255'],
            'department' => ['required', 'integer'],
            'category' => ['required', 'integer'],
            'priority' => ['required', 'integer'],
            'status' => ['required', 'integer']
        ]);

        $status = TicketStatus::firstWhere('status', $request->status);

        $ticket->update([
            'ticket_status_id' => $status->id,
            'ticket_category_id' => $request->category,
            'ticket_department_id' => $request->department,
            'title' => $request->title,
            'message' => $request->message,
            'priority' => $request->priority,
        ]);
        return $this->success([], 'Ticket updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::with('owner')->findOrFail($id);
        if ($ticket->owner->id != auth()->user()->id) {
            return $this->error('You cant delete others tickets', 500);
        }
        $ticket->delete();
        return $this->success([], 'Ticket deleted successfully');
    }
}
