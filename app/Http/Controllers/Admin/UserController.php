<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NotifyUser;
use App\Models\User;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use ResponseHelper;

    public function users()
    {
        return User::with(
            [
                'roles' => function ($q) {
                    $q->whereNot('role_name', 'administrator');
                },
                'owned_tickets'
            ]
        )
            ->whereNot('users.id', auth()->user()->id)
            ->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.admin.dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        return $this->success($user, 'User Found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request, [
            'name' => ['required', 'string'],
            'email' => [
                'required', 'string',
                'email', Rule::unique('users', 'email')->ignore($id)
            ],
            'roles' => ['required']
        ]);

        if ($user->roles->count() != 0) {
            Mail::to($user->email)->send(new NotifyUser([
                'title' => 'Role Updated',
                'body' => 'Your role was updated',
                'url' => route('profile.view')
            ]));
            $user->roles()->sync($request->roles);
        }

        if ($user->roles->count() == 0) {
            Mail::to($user->email)->send(new NotifyUser([
                'title' => 'Role Assigned',
                'body' => 'You are assigned to a role',
                'url' => route('profile.view')
            ]));
            $user->roles()->attach($request->roles);
        }

        $user->update($request->except('_token', 'roles'));

        return $this->success([], 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->roles->count() > 0 || $user->owned_tickets->count() > 0) {
            return $this->error('This user does have any related record yet', 500);
        }
        $user->delete();
        return $this->success([], 'User Deleted Successfully');
    }
}
