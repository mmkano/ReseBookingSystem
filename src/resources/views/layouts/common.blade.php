<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
                    <form class="logout" action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                    <li><a href="{{ route('mypage') }}">Mypage</a></li>
                </ul>
            </nav>
            <a href="" class="logo">Rese</a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @yield('scripts')

</body>
</html>
