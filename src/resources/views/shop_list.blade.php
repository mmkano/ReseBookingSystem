<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>飲食店一覧</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
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

            <div class="sort-container">
                <span class="sort-text" id="sortText" onclick="toggleSortOptions()">
                    並び替え：
                    <span id="selectedSort">
                        @if(request('sort') === 'rating_high')
                            評価が高い順
                        @elseif(request('sort') === 'rating_low')
                            評価が低い順
                        @elseif(request('sort') === 'random')
                            ランダム
                        @else
                            {{-- ソートが選択されていない場合は空白 --}}
                        @endif
                    </span>
                </span>
                <ul id="sortOptions" class="sort-options">
                    <li class="sort-option" onclick="selectSortOption('random')">ランダム</li>
                    <li class="sort-option" onclick="selectSortOption('rating_high')">評価が高い順</li>
                    <li class="sort-option" onclick="selectSortOption('rating_low')">評価が低い順</li>
                </ul>
            </div>

            <div class="search-bar">
                <form action="{{ route('shop_list') }}" method="GET" class="custom">
                    <div class="search-bar-item custom-select">
                        <select name="area" id="area" onchange="this.form.submit()">
                            <option value="all">All area</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->location }}" {{ request('area') == $area->location ? 'selected' : '' }}>
                                    {{ $area->location }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="first-line"></div>
                    <div class="search-bar-item custom-select">
                        <select name="genre" id="genre" onchange="this.form.submit()">
                            <option value="all">All genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->genre }}" {{ request('genre') == $genre->genre ? 'selected' : '' }}>
                                    {{ $genre->genre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="second-line"></div>
                    <div class="search-bar-item">
                        <button type="submit" class="search-icon">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="text" name="search" placeholder="Search ..." value="{{ request('search') }}">
                    </div>
                    <input type="hidden" name="sort" value="{{ request('sort', 'random') }}">
                </form>
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
                            <div class="action-container">
                                <a href="{{ route('shop_detail', ['id' => $shop->id]) }}" class="detail-btn">詳しくみる</a>
                                <form action="{{ auth()->check() && auth()->user()->favorites->contains($shop) ? route('unfavorite.ajax', ['id' => $shop->id]) : route('favorite.ajax', ['id' => $shop->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="like-btn {{ auth()->check() && auth()->user()->favorites->contains($shop) ? 'liked' : '' }}">
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

    <script>
        function toggleSortOptions() {
            const sortOptions = document.getElementById('sortOptions');
            sortOptions.style.display = sortOptions.style.display === 'block' ? 'none' : 'block';
        }

        function selectSortOption(value) {
            const sortText = document.getElementById('selectedSort');
            const sortOptions = document.getElementById('sortOptions');

            if (value === 'random') {
                sortText.textContent = 'ランダム';
            } else if (value === 'rating_high') {
                sortText.textContent = '評価が高い順';
            } else if (value === 'rating_low') {
                sortText.textContent = '評価が低い順';
            } else {
                sortText.textContent = '';
            }

            const form = document.createElement('form');
            form.method = 'GET';
            form.action = '{{ route('shop_list') }}';

            const hiddenSort = document.createElement('input');
            hiddenSort.type = 'hidden';
            hiddenSort.name = 'sort';
            hiddenSort.value = value || '';
            form.appendChild(hiddenSort);

            const hiddenArea = document.createElement('input');
            hiddenArea.type = 'hidden';
            hiddenArea.name = 'area';
            hiddenArea.value = '{{ request('area') }}';
            form.appendChild(hiddenArea);

            const hiddenGenre = document.createElement('input');
            hiddenGenre.type = 'hidden';
            hiddenGenre.name = 'genre';
            hiddenGenre.value = '{{ request('genre') }}';
            form.appendChild(hiddenGenre);

            const hiddenSearch = document.createElement('input');
            hiddenSearch.type = 'hidden';
            hiddenSearch.name = 'search';
            hiddenSearch.value = '{{ request('search') }}';
            form.appendChild(hiddenSearch);

            document.body.appendChild(form);
            form.submit();

            sortOptions.style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const sortParam = '{{ request("sort") }}';
            if (!sortParam) {
                document.getElementById('selectedSort').innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; // 初期化
            }
        });

        document.addEventListener('click', function(event) {
            const sortText = document.getElementById('sortText');
            const sortOptions = document.getElementById('sortOptions');

            if (!sortText.contains(event.target) && !sortOptions.contains(event.target)) {
                sortOptions.style.display = 'none';
            }
        });
    </script>
</body>
</html>