<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportShopsRequest;
use App\Http\Requests\ShopDataRequest;
use App\Http\Requests\StoreOwnerRequest;
use App\Models\Owner;
use App\Models\Review;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function showUsers()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function showUserReviews($userId)
    {
        $user = User::findOrFail($userId);
        $reviews = $user->reviews()->with('shop')->get();
        return view('admin.user_reviews', compact('user', 'reviews'));
    }

    public function storeOwner(StoreOwnerRequest $request)
    {
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

    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $userId = $review->user_id;
        $review->delete();

        return redirect()->route('admin.users.reviews', ['id' => $userId])->with('success', '口コミを削除しました。');
    }

    public function showCreateOwnerForm()
    {
        return view('admin.create_owner');
    }

    public function importShops(ImportShopsRequest $request)
    {
        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));

        array_shift($data);

        foreach ($data as $row) {
            $shopData = [
                'name' => $row[0],
                'location' => $row[1],
                'genre' => $row[2],
                'description' => $row[3],
                'image_url' => $row[4],
            ];

            $shopDataRequest = new ShopDataRequest();
            $shopDataRequest->merge($shopData);
            $shopDataRequest->validate();

            $imageUrl = $shopData['image_url'];
            $extension = strtolower(pathinfo($imageUrl, PATHINFO_EXTENSION));

            if (!in_array($extension, ['jpeg', 'jpg', 'png'])) {
                return redirect()->back()->withErrors(['image_url' => 'アップロード可能な拡張子はjpeg、pngのみです。'])->withInput();
            }

            $imageContents = @file_get_contents($imageUrl);

            if ($imageContents === false) {
                $imagePath = 'shop_images/default.jpg';
            } else {
                $imageName = Str::random(10) . '.' . $extension;
                $relativePath = 'shop_images/' . $imageName;
                Storage::disk('s3')->put($relativePath, $imageContents);
                $imagePath = Storage::disk('s3')->url($relativePath);
            }

            Shop::create([
                'name' => $shopData['name'],
                'location' => $shopData['location'],
                'genre' => $shopData['genre'],
                'description' => $shopData['description'],
                'image_url' => $imagePath,
                'owner_id' => 10,
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'CSVインポートが成功しました');
    }
}
