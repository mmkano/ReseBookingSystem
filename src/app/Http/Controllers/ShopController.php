<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddReviewRequest;
use App\Http\Requests\ReserveRequest;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $area = $request->input('area');
        $genre = $request->input('genre');
        $search = $request->input('search', '');
        $sort = $request->input('sort');

        $query = Shop::query();

        if ($area && $area !== 'all') {
            $query->where('location', $area);
        }

        if ($genre && $genre !== 'all') {
            $query->where('genre', $genre);
        }

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($sort === 'rating_high') {
            $query->withAvg('reviews', 'rating')
                  ->orderByRaw('COALESCE(reviews_avg_rating, 0) DESC, name ASC');
        } elseif ($sort === 'rating_low') {
            $query->withAvg('reviews', 'rating')
                  ->orderByRaw('COALESCE(reviews_avg_rating, 100) ASC, name ASC');
        } elseif ($sort === 'random') {
            $query->inRandomOrder();
        } else {
            $query->orderBy('id', 'asc');
            $sort = null;
        }

        $shops = $query->get();

        $areas = Shop::select('location')->distinct()->get();
        $genres = Shop::select('genre')->distinct()->get();
        $favorites = auth()->check() ? auth()->user()->favorites->pluck('id')->toArray() : [];

        return view('shop_list', compact('shops', 'favorites', 'areas', 'genres', 'search', 'sort'));
    }

    public function favoriteAjax($id)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        $user = Auth::user();
        $shop = Shop::findOrFail($id);

        if ($user->favorites()->where('shop_id', $shop->id)->exists()) {
            $user->favorites()->detach($shop->id);
            return response()->json(['status' => 'unliked']);
        } else {
            $user->favorites()->attach($shop->id);
            return response()->json(['status' => 'liked']);
        }
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
        foreach ($reviews as $review) {
            $review->image_url = $review->image_path ? Storage::disk('s3')->url($review->image_path) : null;
        }

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

    public function reserve(ReserveRequest $request)
    {
        Reservation::create([
            'shop_id' => $request->shop_id,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
        ]);

        return redirect()->route('shop_detail', ['id' => $request->shop_id])->with('success', '予約が完了しました。');
    }

    public function addReview(AddReviewRequest $request, $id)
    {
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
