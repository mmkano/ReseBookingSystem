<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScanQrCodeRequest;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\Reservation;
use App\Models\Shop;
use Illuminate\Http\Request;
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

    public function store(StoreShopRequest $request)
    {
        $path = $request->file('image')->store('shop_images', 's3');
        Storage::disk('s3')->setVisibility($path, 'public');
        $url = Storage::disk('s3')->url($path);

        $owner = Auth::guard('owner')->user();
        $owner->shops()->create([
            'name' => $request->name,
            'location' => $request->location,
            'genre' => $request->genre,
            'description' => $request->description,
            'image_url' => $url,
        ]);

        Auth::guard('owner')->logout();

        return redirect()->route('owner.login')->with('success', '店舗情報を作成しました。');
    }

    public function edit(Shop $shop)
    {
        return view('owner.edit_shop', compact('shop'));
    }

    public function update(UpdateShopRequest $request, Shop $shop)
    {
        if ($request->hasFile('image')) {
            if ($shop->image_url) {
                Storage::disk('s3')->delete($shop->image_url);
            }

            $path = $request->file('image')->store('shop_images', 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $shop->image_url = Storage::disk('s3')->url($path);
        }

        $shop->name = $request->input('name');
        $shop->location = $request->input('location');
        $shop->genre = $request->input('genre');
        $shop->description = $request->input('description');
        $shop->save();

        return redirect()->route('owner.dashboard')->with('success', '店舗情報を更新しました。');
    }

    public function reservations()
    {
        $owner = Auth::guard('owner')->user();
        $shops = $owner->shops;
        $reservations = Reservation::whereIn('shop_id', $shops->pluck('id'))->get();
        $shop = $shops->first();

        return view('owner.reservations.index', compact('reservations', 'shop'));
    }

    public function showReservation(Reservation $reservation)
    {
        $shop = $reservation->shop;

        return view('owner.reservations.show', compact('reservation', 'shop'));
    }

    public function showScanPage()
    {
        $owner = Auth::guard('owner')->user();
        $shop = $owner->shops()->first();

        return view('owner.scan', compact('shop'));
    }

    public function scanQrCode(ScanQrCodeRequest $request)
    {
        $url = $request->input('qr_code');
        $reservationId = basename($url);
        $reservation = Reservation::find($reservationId);

        if ($reservation) {
            $shop = $reservation->shop;
            return view('owner.reservations.show', compact('reservation', 'shop'));
        } else {
            return redirect()->back()->with('error', 'Invalid QR code or reservation not found.');
        }
    }
}
