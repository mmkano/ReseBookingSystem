<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => '山田 太郎', 'email' => 'yamada@example.com', 'password' => Hash::make('password')],
            ['name' => '佐藤 花子', 'email' => 'sato@example.com', 'password' => Hash::make('password')],
            ['name' => '鈴木 一郎', 'email' => 'suzuki@example.com', 'password' => Hash::make('password')],
            ['name' => '田中 美咲', 'email' => 'tanaka@example.com', 'password' => Hash::make('password')],
            ['name' => '高橋 健', 'email' => 'takahashi@example.com', 'password' => Hash::make('password')],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
