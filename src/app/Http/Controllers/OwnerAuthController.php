<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Owner;

class OwnerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.owner_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('owner')->attempt($credentials)) {
            $owner = Auth::guard('owner')->user();
            if ($owner->shops()->exists()) {
                return redirect()->route('owner.dashboard');
            } else {
                return redirect()->route('owner.shops.create');
            }
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::guard('owner')->logout();
        return redirect('/owner/login');
    }

}
