@extends('layouts.app')

@section('title', 'Reseログイン')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
    <div class="login-box">
        <div class="login-header">
            Login
        </div>
        <form action="{{ route('login') }}" method="POST">
            @csrf
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
                <input type="password" name="password" placeholder="Password" >
            </div>
            <div class="login-form__error-message">
                @error('password')
                {{ $message }}
                @enderror
            </div>
            <button type="submit" class="btn">ログイン</button>
        </form>
    </div>
@endsection
