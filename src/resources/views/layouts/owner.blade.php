<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owner/owner.css') }}">
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
                    <li><a href="">Dashboard</a></li>
                    <li><a href="">Reservations</a></li>
                    <li><a href="">Update Store Info</a></li>
                    <li><a href="">Send Mail</a></li>
                    <li><a href="">Scan QR</a></li>
                    <li>
                        <form class="logout" action="" method="post">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </li>
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
