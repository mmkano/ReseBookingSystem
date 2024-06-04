<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index()
    {
        $area = $request->input('area', 'all');

        $query = Shop::query();

        if ($area !== 'all') {
            $query->where('location', $area);
        }

        $shops = $query->get();
        $areas = Shop::select('location')->distinct()->get();

        return view('shop_list', compact('shops', 'areas'));
    }
}
