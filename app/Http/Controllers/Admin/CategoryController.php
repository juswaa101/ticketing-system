<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ResponseHelper;

    public function fetchCategory()
    {
        return TicketCategory::with('ticket')->latest()->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.admin.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name' => ['required', 'string']
        ]);
        TicketCategory::create($request->except('_token'));
        return $this->success([], 'Category added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = TicketCategory::findOrFail($id);
        return $this->success($category, 'Category Found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = TicketCategory::findOrFail($id);
        $this->validate($request, [
            'category_name' => ['required', 'string']
        ]);
        $category->update($request->except('_token'));
        return $this->success([], 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // find existing categories in the related table tickets
        $findCategoryExists = Ticket::join('ticket_categories', 'ticket_categories.id', '=', 'tickets.ticket_category_id')
            ->where('tickets.ticket_category_id', $id)->get();

        // if categories has still a ticket, throw an error
        if ($findCategoryExists->count() > 0) {
            return $this->error('Category has still related records', 500);
        }

        // if categories has no ticket remaining, delete the category
        $category = TicketCategory::findOrFail($id);
        $category->delete();
        return $this->success([], 'Category deleted successfully');
    }
}
