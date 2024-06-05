<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Shop;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shops = Shop::all();
        $users = User::all();
        $comments = [
            '素晴らしいお店でした！',
            'また行きたいです。',
            '料理がとても美味しかったです。',
            'スタッフの対応が丁寧でした。',
            '雰囲気が最高でした。',
            '価格がリーズナブルでした。',
            'アクセスが便利でした。',
            '店内が清潔でした。',
            'おすすめのメニューがあります。',
            'デザートが特に美味しかったです。'
        ];

        foreach ($shops as $shop) {
            for ($i = 0; $i < 5; $i++) {
                Review::create([
                    'shop_id' => $shop->id,
                    'user_id' => $users->random()->id,
                    'rating' => rand(1, 5),
                    'comment' => $comments[array_rand($comments)],
                ]);
            }
        }
    }
}
