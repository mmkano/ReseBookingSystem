<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('styles')
</head>
<body>

    <header class="header">
        <div class="header__inner">
            <input type="checkbox" id="drawer">
            <label for="drawer" class="open"><span></span></label>
            <label for="drawer" class="close"></label>
            <nav class="menu">
                <ul>
                    <li><a href="{{ route('shop_list') }}">Home</a></li>
                    <li><a href="{{ route('register') }}">Registration</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
            </nav>
            <a href="" class="logo">Rese</a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

</body>
</html>
