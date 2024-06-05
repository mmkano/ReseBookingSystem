<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function showRegisterForm(){
        return view('auth.register');
    }

    public function register(RegisterRequest $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = sha1($user->email);
        Mail::send('emails.verify', ['user' => $user, 'token' => $token], function($message) use ($user) {
            $message->to($user->email);
            $message->subject('メールアドレス確認');
        });

        return view('auth.email_sent');
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

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showThanksPage(){
        return view('thanks');
    }

    public function verify(Request $request) {
        $user = User::where('email', $request->email)->first();

        if ($user && sha1($user->email) == $request->token) {
            $user->email_verified_at = now();
            $user->save();
            return view('thanks');
        }

        return redirect()->route('login')->with('error', '無効な認証リンクです。');
    }
}
