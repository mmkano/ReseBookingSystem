<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>飲食店一覧</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/shop_list.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="{{ asset('js/favorites.js') }}" defer></script>
</head>
<body>
    <header class="header">
        <div class="main__header">
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

            <div class="search-bar">
                <div class="search-bar-item custom-select">
                    <form action="{{ route('shop_list') }}" method="GET" class="custom">
                        <select name="area" id="area" onchange="this.form.submit()">
                            <option value="all">All area</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->location }}" {{ request('area') == $area->location ? 'selected' : '' }}>
                                    {{ $area->location }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="first-line"></div>
                <div class="search-bar-item custom-select">
                    <form action="{{ route('shop_list') }}" method="GET">
                        <select name="genre" id="genre" onchange="this.form.submit()">
                            <option value="all">All genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->genre }}" {{ request('genre') == $genre->genre ? 'selected' : '' }}>
                                    {{ $genre->genre }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="second-line"></div>
                <div class="search-bar-item">
                    <form action="{{ route('shop_list') }}" method="GET">
                    <button type="submit" class="search-icon">
                        <i class="fas fa-search"></i>
                    </button>
                        <input type="text" name="search" placeholder="Search ..." value="{{ request('search') }}">
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="rese__content">
            <div class="favorite-cards">
                @foreach($shops as $shop)
                    <div class="favorite-card">
                        <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}">
                        <div class="card-body">
                            <h3>{{ $shop->name }}</h3>
                            <p>#{{ $shop->location }} #{{ $shop->genre }}</p>
                            <div class="one">
                                <a href="{{ route('shop_detail', ['id' => $shop->id]) }}" class="detail-btn">詳しくみる</a>
                                <form action="{{ auth()->user()->favorites->contains($shop) ? route('unfavorite.ajax', ['id' => $shop->id]) : route('favorite.ajax', ['id' => $shop->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="like-btn {{ auth()->user()->favorites->contains($shop) ? 'liked' : '' }}">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</body>
</html>
