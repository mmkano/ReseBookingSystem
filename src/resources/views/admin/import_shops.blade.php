@extends('layouts.admin')

@section('title', 'CSVインポート - 店舗追加')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/import.css') }}">
@endsection

@section('content')
    <div class="import-container">
        <h1 class="import-title">CSVインポート</h1>
        <form action="{{ route('admin.shops.import') }}" method="POST" enctype="multipart/form-data" class="import-form">
            @csrf
            <div class="form-group">
                <label for="csv_file" class="csv-label">CSVファイルを選択</label>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input type="file" name="csv_file" id="csv_file" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-file-import" aria-hidden="true"></i> アップロード
            </button>
        </form>
    </div>
@endsection
