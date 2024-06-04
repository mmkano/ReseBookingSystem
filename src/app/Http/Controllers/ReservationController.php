<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function create($id)
    {
        $shop = Shop::findOrFail($id);
        $times = $this->generateTimeSlots();

        return view('shop_detail', compact('shop', 'times'));
    }

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

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $times = $this->generateTimeSlots();

        return view('edit', compact('reservation', 'times'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'number' => 'required|integer',
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->date = $request->date;
        $reservation->time = $request->time;
        $reservation->number = $request->number;
        $reservation->save();

        return redirect()->route('reservation.edit_done')->with('status', '予約が更新されました');
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

    public function showEditDonePage()
    {
        return view('reservation_edit_done');
    }
}
