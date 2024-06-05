<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    public function showPaymentForm($reservation_id)
    {
        $user = Auth::user();
        $reservation = Reservation::findOrFail($reservation_id);

        return view('payment.form', compact('reservation','user'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount,
                'currency' => 'jpy',
                'payment_method' => $request->payment_method,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('done'),
            ]);

            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function confirmPayment(Request $request)
    {
        $paymentIntentId = $request->query('payment_intent');
        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

        if ($paymentIntent->status === 'succeeded') {
            return redirect()->route('done');
        }

        return redirect()->route('payment.form', ['reservation_id' => $request->query('reservation_id')]);
    }
}
