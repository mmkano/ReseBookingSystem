<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $area = $request->input('area', 'all');
        $genre = $request->input('genre', 'all');

        $query = Shop::query();

        if ($area !== 'all') {
            $query->where('location', $area);
        }

        if ($genre !== 'all') {
            $query->where('genre', $genre);
        }

        $shops = $query->get();
        $areas = Shop::select('location')->distinct()->get();
        $genres = Shop::select('genre')->distinct()->get();

        return view('shop_list', compact('shops', 'areas', 'genres'));
    }
}
