<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{

    public function showDonePage(){
        return view('done');
    }

    public function store(ReservationRequest $request){
        $reservation = new Reservation();
        $reservation->shop_id = $request->input('shop_id');
        $reservation->user_id = auth()->user()->id;
        $reservation->date = $request->input('date');
        $reservation->time = $request->input('time');
        $reservation->number = $request->input('number');
        $reservation->save();

        return redirect()->route('done');
    }

    public function destroy($id)
    {
    $reservation = Reservation::findOrFail($id);
    $reservation->delete();

    return redirect()->route('mypage')->with('status', 'Reservation deleted successfully.');
    }

}
