<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScanQrCodeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'qr_code' => 'required|url',
        ];
    }

    public function messages()
    {
        return [
            'qr_code.required' => 'QRコードを入力してください。',
            'qr_code.url' => '有効なURLを入力してください。',
        ];
    }
}
