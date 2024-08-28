<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:400'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png'],
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '評価は必須です。',
            'comment.max' => 'コメントは400文字以内で入力してください。',
            'image.image' => '画像ファイルのみアップロード可能です。',
            'image.mimes' => 'アップロード可能な画像形式はjpegとpngのみです。',
        ];
    }
}
