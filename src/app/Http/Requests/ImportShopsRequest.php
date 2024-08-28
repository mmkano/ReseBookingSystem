<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportShopsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'csv_file' => 'required|file|mimes:csv,txt',
        ];
    }

    public function messages()
    {
        return [
            'csv_file.required' => 'CSVファイルをアップロードしてください。',
            'csv_file.file' => '有効なファイルを選択してください。',
            'csv_file.mimes' => 'CSVファイルのみアップロード可能です。',
        ];
    }
}
