<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reservations')->truncate();

        $shops = Shop::all();
        $users = User::all();

        if ($shops->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No shops or users found. Skipping reservations seeding.');
            return;
        }

        foreach ($shops as $shop) {
            for ($i = 0; $i < 10; $i++) {
                Reservation::create([
                    'shop_id' => $shop->id,
                    'user_id' => $users->random()->id,
                    'date' => Carbon::now()->addDays(rand(1, 30)),
                    'time' => rand(10, 21) . ':00',
                    'number' => rand(1, 10),
                    'payment_method' => rand(0, 1) ? 'onsite' : 'card',
                ]);
            }
        }
    }
}
