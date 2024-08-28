<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function showSendMailForm()
    {
        $owner = Auth::guard('owner')->user();
        $shop = $owner->shops()->first();

        return view('owner.send_mail', compact('shop'));
    }

    public function sendMail(SendMailRequest $request)
    {
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
