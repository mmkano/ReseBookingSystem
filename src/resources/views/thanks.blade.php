@extends('layouts.app')

@section('title', '会員登録完了')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
    <div class="rese__content">
        <div class="message-box">
            <p>会員登録ありがとうございます</p>
            <form action="{{ route('login') }}" method="GET">
                @csrf
                <button>ログインする</button>
            </form>
        </div>
    </div>
@endsection