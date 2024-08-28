<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReserveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'shop_id' => 'required|exists:shops,id',
            'date' => 'required|date',
            'time' => 'required',
            'number' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'shop_id.required' => '店舗IDが必要です。',
            'shop_id.exists' => '指定された店舗は存在しません。',
            'date.required' => '予約日を入力してください。',
            'date.date' => '有効な日付を入力してください。',
            'time.required' => '時間を入力してください。',
            'number.required' => '人数を入力してください。',
            'number.integer' => '人数は整数で入力してください。',
        ];
    }
}