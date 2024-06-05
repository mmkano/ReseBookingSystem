<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $owner = Auth::guard('owner')->user();
        $shop = $owner->shops()->first();

        if ($shop) {
            return view('owner.dashboard', compact('shop'));
        } else {
            return redirect()->route('owner.shops.create');
        }
    }
}
