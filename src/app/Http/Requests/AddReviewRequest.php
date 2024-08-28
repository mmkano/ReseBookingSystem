<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:400',
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '評価は必須です。',
            'rating.integer' => '評価は整数で入力してください。',
            'rating.min' => '評価は最低1でなければなりません。',
            'rating.max' => '評価は最大5でなければなりません。',
            'comment.string' => 'コメントは文字列で入力してください。',
            'comment.max' => 'コメントは400文字以内で入力してください。',
        ];
    }
}
