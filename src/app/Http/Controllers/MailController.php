<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shop;

class MailController extends Controller
{
    public function showSendMailForm()
    {
        $owner = Auth::guard('owner')->user();
        $shop = $owner->shops()->first();

        return view('owner.send_mail', compact('shop'));
    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $users = User::all();
        $subject = $request->subject;
        $messageBody = $request->message;

        foreach ($users as $user) {
            Mail::raw($messageBody, function ($message) use ($user, $subject) {
                $message->to($user->email)
                        ->subject($subject);
            });
        }

        return redirect()->route('owner.dashboard')->with('success', 'メールを送信しました。');
    }
}
