<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use ResponseHelper;

    public function roles()
    {
        return Role::whereNot('role_name', 'administrator')
            ->with('users', 'tickets')
            ->latest()
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'role_name' => ['required', 'string']
        ]);
        Role::create($request->except('_token'));
        return $this->success([], 'Role Successfully Added');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        return $this->success($role, 'Role Found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);
        $this->validate($request, [
            'role_name' => ['required', 'string']
        ]);
        $role->update($request->except('_token'));
        return $this->success([], 'Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        if ($role->tickets->count() > 0 || $role->users->count() > 0) {
            return $this->error('Role unable to delete, it has a related record', 500);
        }
        $role->delete();
        return $this->success([], 'Role Deleted Successfully');
    }
}
