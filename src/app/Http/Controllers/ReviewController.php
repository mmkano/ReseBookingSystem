<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request, $shopId)
    {
        $validatedData = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:400'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png'],
        ], [
            'rating.required' => '評価は必須です。',
            'comment.max' => 'コメントは400文字以内で入力してください。',
            'image.image' => '画像ファイルのみアップロード可能です。',
            'image.mimes' => 'アップロード可能な画像形式はjpegとpngのみです。',
        ]);

        $review = new Review();
        $review->rating = $validatedData['rating'];
        $review->comment = $validatedData['comment'];
        $review->user_id = auth()->id();
        $review->shop_id = $shopId;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 's3');
            Storage::disk('s3')->setVisibility($imagePath, 'public');
            $review->image_path = Storage::disk('s3')->url($imagePath);
        }

        $review->save();

        return redirect()->route('shop_detail', ['id' => $request->shopId])->with('success', 'レビューが投稿されました。');
    }

    public function show($id)
    {
        $shop = Shop::with('reviews.user')->findOrFail($id);
        return view('shop_detail', compact('shop'));
    }

    public function create($shopId)
    {
        $shop = Shop::findOrFail($shopId);

        $existingReview = Review::where('shop_id', $shopId)
                                ->where('user_id', auth()->id())
                                ->first();

        if ($existingReview) {
            return redirect()->route('shop_detail', ['id' => $shopId])->with('error', '既にこの店舗に対して口コミを投稿しています。');
        }

        return view('review_create', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        Log::info('Review update request received', ['request_data' => $request->all()]);

        $validatedData = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:400'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png'],
        ], [
            'rating.required' => '評価は必須です。',
            'comment.max' => 'コメントは400文字以内で入力してください。',
            'image.image' => '画像ファイルのみアップロード可能です。',
            'image.mimes' => 'アップロード可能な画像形式はjpegとpngのみです。',
        ]);

        $review = Review::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($review->image_path) {
                Storage::disk('s3')->delete($review->image_path);
            }
            $imagePath = $request->file('image')->store('reviews', 's3');
            Storage::disk('s3')->setVisibility($imagePath, 'public');
            $review->image_path = Storage::disk('s3')->url($imagePath);
        } elseif ($review->image_path) {
            $review->image_path = $review->image_path;
        }

        $review->rating = $request->rating;
        $review->comment = $request->comment;

        $review->save();

        Log::info('Review updated:', ['rating' => $review->rating, 'comment' => $review->comment, 'image_path' => $review->image_path]);

        return redirect()->route('shop_detail', ['id' => $review->shop_id])->with('success', '口コミを更新しました');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        if (auth()->id() !== $review->user_id && !auth()->user()->is_admin) {
            return redirect()->route('shop_detail', ['id' => $review->shop_id])->with('error', '削除する権限がありません');
        }

        if ($review->image_path) {
            Storage::disk('s3')->delete($review->image_path);
        }

        $review->delete();

        return redirect()->route('shop_detail', ['id' => $review->shop_id])->with('success', '口コミを削除しました');
    }
}