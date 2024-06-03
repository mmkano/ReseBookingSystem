@extends('layouts.common')

@section('title', '予約完了')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
    <div class="rese__content">
        <div class="message-box">
            <p>ご予約ありがとうございます</p>
            <button onclick="window.location.href='{{ route('shop_list') }}'">戻る</button>
        </div>
    </div>
@endsection
