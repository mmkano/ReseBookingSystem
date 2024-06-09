@extends('layouts.common')

@section('title', '予約変更完了')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
    <div class="rese__content">
        <div class="message-box">
            <p>予約変更が完了しました</p>
            <button onclick="window.location.href='{{ route('mypage') }}'">戻る</button>
        </div>
    </div>
@endsection
