<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Owner;


class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.owners.create');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showCreateOwnerForm()
    {
        return view('admin.create_owner');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }


    public function storeOwner(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:owners',
            'password' => 'required|string|min:5',
        ]);

        Owner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.owners.done')->with('success', '店舗代表者を作成しました。');
    }

    public function showOwnerCreationDonePage()
    {
        return view('admin.owner_creation_done');
    }
}
