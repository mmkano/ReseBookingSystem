@extends('layouts.common')

@section('title', '予約変更')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
<div class="rese__content">
    <div class="container">
        <h1>予約変更</h1>
        <form action="{{ route('reservation.update', $reservation->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="date">予約日</label>
                <input type="date" name="date" id="date" value="{{ $reservation->date }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="time">予約時間</label>
                <select name="time" id="time" class="form-control">
                    @foreach ($times as $time)
                        <option value="{{ $time }}" {{ $time == $reservation->time ? 'selected' : '' }}>{{ $time }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="number">人数</label>
                <input type="number" name="number" id="number" value="{{ $reservation->number }}" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">変更を保存</button>
        </form>
    </div>
</div>

@endsection
