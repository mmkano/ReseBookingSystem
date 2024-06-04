<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
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
}
