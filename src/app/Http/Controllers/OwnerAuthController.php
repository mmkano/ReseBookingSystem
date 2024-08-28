<?php

namespace App\Http\Controllers;

use App\Http\Requests\OwnerLoginRequest;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.owner_login');
    }

    public function login(OwnerLoginRequest $request)
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
            'email' => '提供された認証情報が記録と一致しません。',
        ]);
    }

    public function logout()
    {
        Auth::guard('owner')->logout();
        return redirect('/owner/login');
    }
}
