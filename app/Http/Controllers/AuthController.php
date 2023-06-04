<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateForm\LoginRequest;
use App\Http\Requests\AuthenticateForm\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return back()->with('error', 'Email or password is incorrect!');
        }

        $user = User::whereEmail($request->email)->first();
        $user_roles = [];
        foreach ($user->roles as $role) {
            array_push($user_roles, $role->role_name);
        }

        if (in_array('administrator', $user_roles)) {
            return $user->email_verified_at != null ? redirect()->route('admin.dashboard')
                ->with('success', 'Welcome, ' . auth()->user()->name . '!') : redirect()->route('verify');
        }
        return $user->email_verified_at != null ? redirect()->route('user.dashboard')
            ->with('success', 'Welcome, ' . auth()->user()->name . '!') : redirect()->route('verify');
    }

    public function register(RegisterRequest $request)
    {
        User::create($request->except('_token', 'password_confirmation'));
        return back()->with('success', 'Account has been created successfully!');
    }

    public function loginPage()
    {
        return view('login');
    }

    public function registerPage()
    {
        return view('register');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
