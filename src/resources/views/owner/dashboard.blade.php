@extends('layouts.owner')

@section('title', '店舗管理ダッシュボード')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/owner/dashboard.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    <div class="dashboard-box special-margin" onclick="location.href='{{ route('owner.shops.edit', $shop->id) }}'">
        店舗情報の更新
    </div>
    <div class="dashboard-box" onclick="location.href='{{ route('owner.reservations.index') }}'">
        予約状況
    </div>
    <div class="dashboard-box special-margin" onclick="location.href='{{ route('owner.send_mail') }}'">
        メール送信
    </div>
    <div class="dashboard-box" onclick="location.href='{{ route('owner.qr_scan') }}'">
        QRコードスキャン
    </div>
</div>
@endsection
