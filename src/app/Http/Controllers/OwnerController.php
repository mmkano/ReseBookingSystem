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

    public function create()
    {
        return view('owner.create_shop');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $path = $request->file('image')->store('public/shop_images');

        $owner = Auth::guard('owner')->user();
        $owner->shops()->create([
            'name' => $request->name,
            'location' => $request->location,
            'genre' => $request->genre,
            'description' => $request->description,
            'image_url' => Storage::url($path),
        ]);

        Auth::guard('owner')->logout();

        return redirect()->route('owner.login')->with('success', '店舗情報を作成しました。');
    }

    public function edit(Shop $shop)
    {
        return view('owner.edit_shop', compact('shop'));
    }

    public function update(Request $request, Shop $shop)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
        ]);

        if ($request->hasFile('image')) {
            if ($shop->image_url) {
                Storage::delete(str_replace('/storage', 'public', $shop->image_url));
            }

            $path = $request->file('image')->store('public/shop_images');
            $shop->image_url = Storage::url($path);
        }

        $shop->name = $request->input('name');
        $shop->location = $request->input('location');
        $shop->genre = $request->input('genre');
        $shop->description = $request->input('description');
        $shop->save();

        return redirect()->route('owner.dashboard')->with('success', '店舗情報を更新しました。');
    }

}
