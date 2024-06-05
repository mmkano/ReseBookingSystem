@extends('layouts.owner')

@section('title', '予約詳細')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/owner/show.css') }}">
@endsection

@section('content')
<div class="container">
    <h1>予約詳細</h1>
    <table class="detail-table">
        <tr>
            <th>予約ID</th>
            <td>{{ $reservation->id }}</td>
        </tr>
        <tr>
            <th>ユーザー名</th>
            <td>{{ $reservation->user->name }}</td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>{{ $reservation->user->email }}</td>
        </tr>
        <tr>
            <th>日付</th>
            <td>{{ $reservation->date }}</td>
        </tr>
        <tr>
            <th>時間</th>
            <td>{{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</td>
        </tr>
        <tr>
            <th>人数</th>
            <td>{{ $reservation->number }}</td>
        </tr>
    </table>
</div>
@endsection
