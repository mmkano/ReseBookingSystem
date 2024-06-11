@extends('layouts.owner')

@section('title', '店舗情報編集')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/owner/edit.css') }}">
@endsection

@section('content')
<div class="edit-container">
    <h1>店舗情報編集</h1>
    <form action="{{ route('owner.shops.update', $shop) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="name">店舗名</label>
            <input type="text" id="name" name="name" value="{{ old('name', $shop->name) }}">
            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="location">地域</label>
            <input type="text" id="location" name="location" value="{{ old('location', $shop->location) }}">
            @error('location')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="genre">ジャンル</label>
            <input list="genres" id="genre" name="genre" value="{{ old('genre', $shop->genre) }}">
            <datalist id="genres">
                <option value="寿司">寿司</option>
                <option value="焼肉">焼肉</option>
                <option value="居酒屋">居酒屋</option>
                <option value="イタリアン">イタリアン</option>
                <option value="ラーメン">ラーメン</option>
            </datalist>
            @error('genre')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="description">概要</label>
            <textarea id="description" name="description">{{ old('description', $shop->description) }}</textarea>
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
        <button type="submit">更新</button>
    </form>
</div>
@endsection
