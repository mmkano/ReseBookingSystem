@extends('layouts.admin')

@section('title', 'Rese店舗代表者の作成')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
@endsection

@section('content')
<div class="login-box">
    <div class="login-header">
        店舗代表者の作成
    </div>
    <form action="{{ route('admin.owners.store') }}" method="POST">
        @csrf
        <div class="input-group">
            <span class="icon"><i class="fa fa-user"></i></span>
            <input type="text" name="name" placeholder="Username" value="{{ old('name') }}">
        </div>
        <div class="login-form__error-message">
            @error('name')
            {{ $message }}
            @enderror
        </div>
        <div class="input-group">
            <span class="icon"><i class="fa fa-envelope"></i></span>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
        </div>
        <div class="login-form__error-message">
            @error('email')
            {{ $message }}
            @enderror
        </div>
        <div class="input-group">
            <span class="icon"><i class="fa fa-lock"></i></span>
            <input type="password" name="password" placeholder="Password">
        </div>
        <div class="login-form__error-message">
            @error('password')
            {{ $message }}
            @enderror
        </div>
        <button type="submit" class="btn">作成</button>
    </form>
</div>
@endsection
