@extends('layouts.owner')

@section('title', '予約リスト')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
@endsection

@section('content')
<div class="user-container">
    <h1>予約リスト</h1>
    <table>
        <thead>
            <tr>
                <th>予約ID</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->id }}</td>
                    <td><a href="{{ route('owner.reservations.show', $reservation) }}">詳細</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
