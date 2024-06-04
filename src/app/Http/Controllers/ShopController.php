<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $area = $request->input('area', 'all');
        $genre = $request->input('genre', 'all');
        $search = $request->input('search', '');

        $query = Shop::query();

        if ($area !== 'all') {
            $query->where('location', $area);
        }

        if ($genre !== 'all') {
            $query->where('genre', $genre);
        }

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $shops = $query->get();
        $areas = Shop::select('location')->distinct()->get();
        $genres = Shop::select('genre')->distinct()->get();
        $favorites = auth()->user() ? auth()->user()->favorites->pluck('shop_id')->toArray() : [];

        return view('shop_list', compact('shops', 'favorites', 'areas', 'genres', 'search'));
    }

    public function favoriteAjax($id)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        $shop = Shop::findOrFail($id);
        Auth::user()->favorites()->attach($shop->id);

        return response()->json(['status' => 'liked']);
    }

    public function favorite($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $shop = Shop::findOrFail($id);
        Auth::user()->favorites()->attach($shop->id);

        return redirect()->back();
    }
}
