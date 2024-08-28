<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopDataRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'location' => 'required|string|in:東京都,大阪府,福岡県',
            'genre' => 'required|string|in:寿司,焼肉,イタリアン,居酒屋,ラーメン',
            'description' => 'required|string|max:400',
            'image_url' => 'required|string|url',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店舗名を入力してください。',
            'location.required' => '所在地を入力してください。',
            'location.in' => '有効な所在地を選択してください。',
            'genre.required' => 'ジャンルを入力してください。',
            'genre.in' => '有効なジャンルを選択してください。',
            'description.required' => '説明を入力してください。',
            'description.max' => '説明は400文字以内で入力してください。',
            'image_url.required' => '画像URLを入力してください。',
            'image_url.url' => '有効なURLを入力してください。',
        ];
    }
}
