<?php

namespace App\Http\Controllers;

use App\Mail\VerifyUserEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class VerifyUserController extends Controller
{
    public function index()
    {
        if (Gate::allows('admin')) {
            return view('auth.admin.dashboard');
        }
        return view('auth.user.dashboard');
    }

    public function sendVerification(Request $request)
    {
        if (auth()->user()->email_verified_at != null) {
            return redirect()->back()
                ->with('success', 'Your account is already verified');
        } else {
            Mail::to(auth()->user()->email)->send(new VerifyUserEmail([
                'body' => 'Thanks for Signing Up! Before getting started, could your verify your email address by clicking
                    on the link we just emailed to you? If you didnt receive the email, we will gladly send you
                    another.',
                'url' => route('verify.email', auth()->user()->id)
            ]));

            return redirect()->back()
                ->with('success', 'Verification was sent to your email, please check your inbox');
        }
    }

    public function verifyUser(User $user)
    {
        $user->update([
            'email_verified_at' => now()
        ]);

        $checkAbility = Gate::allows('admin') ? 'admin.dashboard' : 'user.dashboard';

        return redirect()->route($checkAbility)
            ->with('success', 'Email Verified, You can now use your account');
    }
}
