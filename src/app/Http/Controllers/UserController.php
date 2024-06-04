<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();
        $favorites = $user->favorites;

        return view('mypage', compact('user', 'favorites'));
    }
}
