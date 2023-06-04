<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    public function index()
    {
        if (Gate::allows('admin')) {
            return view('auth.admin.dashboard');
        }
        return view('auth.user.dashboard');
    }
}
