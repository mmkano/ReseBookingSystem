<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Review;
use App\Models\Reservation;
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
        $favorites = auth()->user() ? auth()->user()->favorites->pluck('id')->toArray() : [];

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

    public function unfavoriteAjax($id)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        $shop = Shop::findOrFail($id);
        Auth::user()->favorites()->detach($shop->id);

        return response()->json(['status' => 'unliked']);
    }

    public function unfavorite($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $shop = Shop::findOrFail($id);
        Auth::user()->favorites()->detach($shop->id);

        return redirect()->back();
    }

    public function show($id)
    {
        $shop = Shop::with('reviews.user')->findOrFail($id);
        $times = $this->generateTimeSlots();
        $reviews = $shop->reviews;
        $averageRating = $reviews->avg('rating');

        return view('shop_detail', compact('shop', 'times', 'reviews', 'averageRating'));
    }

    private function generateTimeSlots()
    {
    $times = [];
    $start = strtotime('00:00');
    $end = strtotime('23:30');

    while ($start <= $end) {
        $times[] = date('H:i', $start);
        $start = strtotime('+30 minutes', $start);
    }

    return $times;
    }

    public function store(Request $request)
    {
    $data = $request->all();
    session([
        'shop_id' => $data['shop_id'],
        'date' => $data['date'],
        'time' => $data['time'],
        'number' => $data['number'],
    ]);

    return redirect()->route('shop_detail', ['id' => $data['shop_id']]);
    }

    public function reserve(Request $request)
    {
    $request->validate([
        'shop_id' => 'required|exists:shops,id',
        'date' => 'required|date',
        'time' => 'required',
        'number' => 'required|integer',
    ]);

    Reservation::create([
        'shop_id' => $request->shop_id,
        'user_id' => Auth::id(),
        'date' => $request->date,
        'time' => $request->time,
        'number' => $request->number,
    ]);

    return redirect()->route('shop_detail', ['id' => $request->shop_id])->with('success', '予約が完了しました。');
    }

    public function addReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $shop = Shop::findOrFail($id);

        Review::create([
            'shop_id' => $shop->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->route('shop_detail', ['id' => $shop->id])->with('success', 'レビューを追加しました');
    }
}
