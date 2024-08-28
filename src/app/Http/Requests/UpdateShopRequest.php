<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店舗名を入力してください。',
            'location.required' => '所在地を入力してください。',
            'genre.required' => 'ジャンルを入力してください。',
            'description.required' => '説明を入力してください。',
            'image.image' => '有効な画像ファイルを選択してください。',
            'image.mimes' => 'jpeg, png, jpg, gifのいずれかの形式で画像をアップロードしてください。',
            'image.max' => '画像ファイルのサイズは5MB以下にしてください。',
        ];
    }
}
