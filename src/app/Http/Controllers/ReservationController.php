<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservationController extends Controller
{
    public function create($id)
    {
        $shop = Shop::findOrFail($id);
        $times = $this->generateTimeSlots();

        return view('shop_detail', compact('shop', 'times'));
    }

    public function showDonePage()
    {
        return view('done');
    }

    public function store(ReservationRequest $request)
    {
        $reservationDate = $request->input('date');
        $reservationTime = $request->input('time');
        $reservationDateTime = strtotime($reservationDate . ' ' . $reservationTime);

        $currentDateTime = time();

        if ($reservationDateTime <= $currentDateTime) {
            return redirect()->back()->withErrors(['time' => '予約時間は現在の時間より後を指定してください。']);
        }

        $reservation = new Reservation();
        $reservation->shop_id = $request->input('shop_id');
        $reservation->user_id = auth()->user()->id;
        $reservation->date = $reservationDate;
        $reservation->time = $reservationTime;
        $reservation->number = $request->input('number');
        $reservation->payment_method = $request->input('payment_method');
        $reservation->save();

        if ($request->input('payment_method') == 'card') {
            return redirect()->route('payment.form', ['reservation_id' => $reservation->id]);
        }

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

        $reservationDate = $request->date;
        $reservationTime = $request->time;
        $reservationDateTime = strtotime($reservationDate . ' ' . $reservationTime);

        $currentDateTime = time();

        if ($reservationDateTime <= $currentDateTime) {
            return redirect()->back()->withErrors(['time' => '予約時間は現在の時間より後を指定してください。']);
        }

        $reservation = Reservation::findOrFail($id);
        $reservation->date = $reservationDate;
        $reservation->time = $reservationTime;
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

    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('owner.reservations.show', $reservation->id));

        return view('owner.reservations.show', compact('reservation', 'qrCode'));
    }
}
