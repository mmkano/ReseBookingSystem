@extends('layouts.owner')

@section('title', 'メール送信')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/owner/mail.css') }}">
@endsection

@section('content')
<div class="mail-container">
    <h1>お知らせメールの送信</h1>
    <form action="{{ route('owner.send_mail.post') }}" method="POST">
        @csrf
        <div>
            <label for="subject">件名:</label>
            <input type="text" id="subject" name="subject" required>
        </div>
        <div>
            <label for="message">本文:</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <button type="submit">送信</button>
    </form>
</div>
@endsection
