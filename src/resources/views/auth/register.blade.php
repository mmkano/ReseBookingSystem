@extends('layouts.app')

@section('title', 'Rese登録')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
    <div class="register-box">
        <div class="register-header">
            Registration
        </div>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="input-group">
                <span class="icon"><i class="fa fa-user"></i></span>
                <input type="text" name="name" placeholder="Username" value="{{ old('name') }}" >
            </div>
            <div class="register-form__error-message">
                @error('name')
                {{ $message }}
                @enderror
            </div>
            <div class="input-group">
                <span class="icon"><i class="fa fa-envelope"></i></span>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" >
            </div>
            <div class="register-form__error-message">
                @error('email')
                {{ $message }}
                @enderror
            </div>
            <div class="input-group">
                <span class="icon"><i class="fa fa-lock"></i></span>
                <input type="password" name="password" placeholder="Password">
            </div>
            <div class="register-form__error-message">
                @error('password')
                {{ $message }}
                @enderror
            </div>
            <button type="submit" class="btn">登録</button>
        </form>
    </div>
@endsection
