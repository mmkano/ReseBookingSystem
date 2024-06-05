<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese店舗代表者ログイン</title>
    <link rel="stylesheet" href="{{ asset('css/owner/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <header class="header">
        <div class="header__inner">
            <input type="checkbox" id="drawer">
            <label for="drawer" class="open"><span></span></label>
            <label for="drawer" class="close"></label>
            <nav class="menu">
                <ul>
                    <li><a href="{{ route('owner.login') }}">Login</a></li>
                </ul>
            </nav>
            <a href="" class="logo">Rese</a>
        </div>
    </header>

    <main>
    <div class="login-box">
            <div class="login-header">
                Login
            </div>
            <form action="{{ route('owner.login') }}" method="POST">
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
    </main>

</body>
</html>
