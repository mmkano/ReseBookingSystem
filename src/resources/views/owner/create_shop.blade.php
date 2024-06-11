@extends('layouts.owner')

@section('title', '店舗情報作成')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/owner/create.css') }}">
@endsection

@section('content')
<div class="edit-container">
    <h1>店舗情報作成</h1>
    <form action="{{ route('owner.shops.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="name">店舗名</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="location">地域</label>
            <input type="text" id="location" name="location" value="{{ old('location') }}">
            @error('location')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="genre">ジャンル</label>
            <input list="genres" id="genre" name="genre" value="{{ old('genre') }}">
            <datalist id="genres">
                <option value="寿司">
                <option value="焼肉">
                <option value="ラーメン">
                <option value="居酒屋">
                <option value="イタリアン">
            </datalist>
            @error('genre')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description">概要</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
            @error('description')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="image">画像アップロード</label>
            <input type="file" id="image" name="image">
            @error('image')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">作成</button>
    </form>
</div>
@endsection
