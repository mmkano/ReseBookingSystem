<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shop_id' => 'required|exists:shops,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'number' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'shop_id.required' => '店舗IDは必須です。',
            'shop_id.exists' => '存在しない店舗IDです。',
            'date.required' => '予約日は必須です。',
            'date.date' => '有効な日付を入力してください。',
            'date.after_or_equal' => '予約日は今日以降の日付を入力してください。',
            'time.required' => '予約時間は必須です。',
            'time.date_format' => '有効な時間形式（HH:MM）を入力してください。',
            'number.required' => '人数は必須です。',
            'number.integer' => '人数は整数で入力してください。',
            'number.min' => '人数は1人以上で入力してください。',
        ];
    }
}
