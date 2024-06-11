<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Owner;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owners = [
            ['name' => 'Owner Sennin', 'email' => 'sennin@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Gyusuke', 'email' => 'gyusuke@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Senritsu', 'email' => 'senritsu@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Luke', 'email' => 'luke@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Shimaya', 'email' => 'shimaya@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Kou', 'email' => 'kou@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner JJ', 'email' => 'jj@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner RamenKiwami', 'email' => 'ramenkiwami@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Toriame', 'email' => 'toriame@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Tsukiji', 'email' => 'tsukiji@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Harumi', 'email' => 'harumi@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Mitsuko', 'email' => 'mitsuko@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Hakkai', 'email' => 'hakkai@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Fukusuke', 'email' => 'fukusuke@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner RaHoku', 'email' => 'rahoku@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Sho', 'email' => 'sho@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Kei', 'email' => 'kei@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Uru', 'email' => 'uru@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner TheTool', 'email' => 'thetool@example.com', 'password' => Hash::make('password')],
            ['name' => 'Owner Kifune', 'email' => 'kifune@example.com', 'password' => Hash::make('password')],
        ];

        foreach ($owners as $ownerData) {
            Owner::create($ownerData);
        }
    }
}
