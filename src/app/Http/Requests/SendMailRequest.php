<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => '件名を入力してください。',
            'subject.string' => '件名は文字列でなければなりません。',
            'subject.max' => '件名は255文字以内で入力してください。',
            'message.required' => 'メッセージを入力してください。',
            'message.string' => 'メッセージは文字列でなければなりません。',
        ];
    }
}
