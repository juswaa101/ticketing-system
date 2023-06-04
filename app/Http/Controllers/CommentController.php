<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    use ResponseHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'comment' => ['required', 'string']
        ]);
        Comment::create([
            'user_id' => auth()->user()->id,
            'ticket_id' => $request->ticketId,
            'comment' => $request->comment
        ]);
        return $this->success([], 'Comment Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::with('user')
            ->where('ticket_id', $id)
            ->latest()
            ->limit(10)
            ->get();

        if (!$comment) {
            return $this->error('Not Found', 404);
        }
        return $this->success($comment, 'Comment Found');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comment = Comment::findOrFail($id);
        return $this->success($comment, 'Comment Found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update($request->except('_token'));
        $this->validate($request, [
            'comment' => ['required', 'string']
        ]);
        $this->success([], 'Comment Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        $this->success([], 'Comment Deleted Successfully!');
    }
}
