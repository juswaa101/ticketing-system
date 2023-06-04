<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SettingsController extends Controller
{
    public function index()
    {
        if (Gate::allows('admin')) {
            return view('auth.admin.dashboard');
        }
        return view('auth.user.dashboard');
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email,' . auth()->user()->id . ',id'],
            'password_confirmation' => ['same:password']
        ]);

        if ($request->password) {
            auth()->user()->update([
                'password' => $request->password
            ]);
        }

        $oldEmail = auth()->user()->email;

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        if ($oldEmail != $request->email) {
            auth()->user()->update([
                'email_verified_at' => null
            ]);

            return redirect()->route('verify');
        }

        return back()->with('success', 'Profile Updated');
    }
}
