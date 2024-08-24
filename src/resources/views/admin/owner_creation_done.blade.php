@extends('layouts.admin')

@section('title', '作成完了')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/done.css') }}">
@endsection

@section('content')
    <div class="rese__content">
        <div class="message-box">
            <p>店舗代表者の作成が完了しました</p>
            <form class="logout-form" action="{{ route('admin.dashboard') }}" method="get">
                @csrf
                <button type="submit" class="btn btn-primary">戻る</button>
            </form>
        </div>
    </div>
@endsection
