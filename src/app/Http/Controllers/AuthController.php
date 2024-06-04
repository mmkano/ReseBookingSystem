<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function showRegisterForm(){
        return view('auth.register');
    }

    public function register(RegisterRequest $request) {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('thanks');
    }

    public function showThanksPage(){
        return view('thanks');
    }

    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();
        if ($user && !$user->email_verified_at) {
            return back()->withErrors(['email' => 'メールアドレスが確認されていません。']);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('shop_list');
        }

        return back()->withErrors(['email' => '提供された認証情報が記録と一致しません。']);
    }
}