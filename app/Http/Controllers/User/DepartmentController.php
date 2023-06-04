<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return Role::whereNot('role_name', 'administrator')->latest()->get();
    }
}
