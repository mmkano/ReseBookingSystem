<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Reservation;
use Carbon\Carbon;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '予約当日のリマインダーをユーザーに送信します';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();
        $reservations = Reservation::where('date', $today)->get();

        foreach ($reservations as $reservation) {
            $user = $reservation->user;
            $shop = $reservation->shop;
            $reservationTime = Carbon::parse($reservation->time)->format('H:i');

            Mail::raw("本日{$shop->name}でのご予約のご連絡です。予約時間は{$reservationTime}です。", function ($message) use ($user, $shop) {
                $message->to($user->email)
                        ->subject("Reminder: Reservation at {$shop->name}");
            });
        }

        $this->info('Reminders sent successfully!');
    }
}
