@extends('layouts.common')

@section('title', $user->name . 'さんのマイページ')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="rese__content">
        <div class="content">
            <div class="reservations">
                <h2>予約状況</h2>
                @foreach ($reservations as $reservation)
                    <div class="reservation-card">
                        <div class="reservation-header">
                            <span><i class="fas fa-clock"></i> 予約{{ $loop->iteration }}</span>
                            <a href="{{ route('reservation.edit', $reservation->id) }}" class="edit-btn">予約変更</a>
                            <form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="close-btn">&times;</button>
                            </form>
                        </div>
                        <div class="reservation-body">
                            <p>Shop: {{ $reservation->shop->name }}</p>
                            <p>Date: {{ $reservation->date }}</p>
                            <p>Time: {{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</p>
                            <p>Number: {{ $reservation->number }}人</p>
                            <p>Payment: {{ $reservation->payment_method == 'onsite' ? '現地決済' : 'カード決済' }}</p>
                            <div class="qr-code">
                                {!! QrCode::size(100)->generate(route('owner.reservations.show', $reservation->id)) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="favorites">
                <h1>{{ $user->name }}さん</h1>
                <h2>お気に入り店舗</h2>
                <div class="favorite-cards">
                    @foreach ($favorites as $favorite)
                        <div class="favorite-card">
                            <img src="{{ $favorite->image_url }}" alt="{{ $favorite->name }}">
                            <div class="card-body">
                                <h3>{{ $favorite->name }}</h3>
                                <p>#{{ $favorite->location }} #{{ $favorite->genre }}</p>
                                <div class="one">
                                    <a href="{{ route('shop_detail', ['id' => $favorite->id]) }}" class="detail-btn">詳しくみる</a>
                                    <form action="{{ route('unfavorite', ['id' => $favorite->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="like-btn"><i class="fas fa-heart"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection