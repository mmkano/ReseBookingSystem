@extends('layouts.common')

@section('title', $shop->name . '詳細情報')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}">
@endsection

@section('content')
    <div class="rese__content">
        <div class="rese-sub">
            <div class="shop-info">
                <div class="shop-ttl">
                    <a href="{{ route('shop_list') }}" class="back-btn">&lt;</a>
                    <h1>{{ $shop->name }}</h1>
                </div>
                <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}">
                <p>#{{ $shop->location }} #{{ $shop->genre }}</p>
                <p>{{ $shop->description }}</p>
            </div>

            <div class="reservation">
                <div class="one">
                    <h2>予約</h2>
                    <form action="{{ route('reserve') }}" method="POST">
                        @csrf
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <input type="date" id="date" name="date" value="{{ old('date') }}">
                        @error('date')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <select id="time" name="time">
                            @foreach ($times as $time)
                                <option value="{{ $time }}" {{ old('time') == $time ? 'selected' : '' }}>{{ $time }}</option>
                            @endforeach
                        </select>
                        @error('time')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <select id="number" name="number">
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('number') == $i ? 'selected' : '' }}>{{ $i }}人</option>
                            @endfor
                        </select>
                        @error('number')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <div class="reservation-summary">
                            <p>Shop: {{ $shop->name }}</p>
                            <p>Date: <span id="selected-date">{{ old('date') }}</span></p>
                            <p>Time: <span id="selected-time">{{ old('time') }}</span></p>
                            <p>Number: <span id="selected-number">{{ old('number') }}</span></p>
                        </div>
                        <button type="submit">予約する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection