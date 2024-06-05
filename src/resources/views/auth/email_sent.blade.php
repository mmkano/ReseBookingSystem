@extends('layouts.app')

@section('title', '本登録')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth/email.css') }}">
@endsection

@section('content')
    <div class="rese__content">
        <div class="message-box">
            <p>本登録をお願いします。<br>メールをお送りしましたので確認をお願いします。</p>
        </div>
    </div>
@endsection
