<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessPaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => '支払金額を入力してください。',
            'amount.numeric' => '支払金額は数値で入力してください。',
            'amount.min' => '支払金額は1以上でなければなりません。',
            'payment_method.required' => '支払方法を選択してください。',
            'payment_method.string' => '支払方法が無効です。',
        ];
    }
}

