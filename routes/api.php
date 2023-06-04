<?php

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tickets', function () {
    return Ticket::with('owner', 'status', 'category', 'logs', 'comments', 'department')->get();
});

Route::get('/users', function () {
    return User::with('owned_tickets', 'comments', 'logs')->get();
});

Route::get('/categories', function () {
    return TicketCategory::all();
});

Route::get('/comments', function () {
    return Comment::with('user', 'ticket')->get();
});
