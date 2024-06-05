<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $shop->name }}詳細情報</title>
    <link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
                <li>
                <form class="logout" action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
                </li>
                <li><a href="{{ route('mypage') }}">Mypage</a></li>
            </ul>
        </nav>
        <a href="" class="logo">Rese</a>
    </div>
</header>

<main>
    <div class="rese__content">
    <div class="rese-sub">
        <div class="shop-info">
            <div class="shop-ttl">
                <a href="{{ route('shop_list') }}" class="back-btn">&lt;</a>
                <h1>{{ $shop->name }}</h1>
            </div>
            <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}">
            <p>#{{ $shop->location }} #{{ $shop->genre }}</p>
            <p>{{ $shop->description }}</p>
        </div>

        <div class="reservation">
            <div class="one">
                <h2>予約</h2>
                <form action="{{ route('reserve') }}" method="POST">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <input type="date" id="date" name="date"  value="{{ old('date') }}">
                    @error('date')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <select id="time" name="time" >
                        @foreach ($times as $time)
                            <option value="{{ $time }}" {{ old('time') == $time ? 'selected' : '' }}>{{ $time }}</option>
                        @endforeach
                    </select>
                    @error('time')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <select id="number" name="number" >
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ old('number') == $i ? 'selected' : '' }}>{{ $i }}人</option>
                        @endfor
                    </select>
                    @error('number')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <select id="payment_method" name="payment_method" onchange="updatePaymentMethod()">
                        <option value="onsite" {{ old('payment_method') == 'onsite' ? 'selected' : '' }}>現地決済</option>
                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>カード決済</option>
                    </select>
                    @error('payment_method')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="reservation-summary">
                        <p>Shop: {{ $shop->name }}</p>
                        <p>Date: <span id="selected-date">{{ old('date') }}</span></p>
                        <p>Time: <span id="selected-time">{{ old('time') }}</span></p>
                        <p>Number: <span id="selected-number">{{ old('number') }}</span></p>
                        <p>Payment: <span id="selected-payment_method">{{ old('payment_method') }}</span></p>
                    </div>
                    <button type="submit">予約する</button>
                </form>
            </div>
        </div>
    </div>

        <div class="reviews-info">
            <div class="reviews">
                <h2>評価:
                    @if($averageRating)
                        @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= round($averageRating))
                                <span class="fa fa-star checked"></span>
                            @else
                                <span class="fa fa-star"></span>
                            @endif
                        @endfor
                        ({{ round($averageRating, 1) }} / 5)
                    @else
                        <span>評価なし</span>
                    @endif
                </h2>
                <button class="btn btn-primary" data-toggle="modal" data-target="#reviewModal">評価する</button>
            </div>

            <div class="review-list">
                @foreach($reviews as $review)
                    <div class="review">
                        <p>{{ $review->user->name }}: 
                            @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->rating)
                                    <span class="fa fa-star checked"></span>
                                @else
                                    <span class="fa fa-star"></span>
                                @endif
                            @endfor
                        </p>
                        <p>{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- レビューモーダル -->
        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel">レビューを追加</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('shop.addReview', ['id' => $shop->id]) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="rating">評価</label>
                                <div id="rating" class="star-rating">
                                    <input type="radio" name="rating" value="5" id="5-stars" required>
                                    <label for="5-stars" class="star">&#9733;</label>
                                    <input type="radio" name="rating" value="4" id="4-stars">
                                    <label for="4-stars" class="star">&#9733;</label>
                                    <input type="radio" name="rating" value="3" id="3-stars">
                                    <label for="3-stars" class="star">&#9733;</label>
                                    <input type="radio" name="rating" value="2" id="2-stars">
                                    <label for="2-stars" class="star">&#9733;</label>
                                    <input type="radio" name="rating" value="1" id="1-star">
                                    <label for="1-star" class="star">&#9733;</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="comment">コメント</label>
                                <textarea name="comment" id="comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                            <button type="submit" class="btn btn-primary">送信</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</main>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-rating .star');
    const starInputs = document.querySelectorAll('.star-rating input[type="radio"]');

    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = star.previousElementSibling.value;
            starInputs.forEach(input => input.checked = false);
            star.previousElementSibling.checked = true;
            stars.forEach((s, i) => {
                s.style.color = i < rating ? '#f5b301' : '#ddd';
            });
        });

        star.addEventListener('mouseover', function() {
            stars.forEach(s => s.style.color = '#ddd');
            for (let i = 0; i <= index; i++) {
                stars[i].style.color = '#f5b301';
            }
        });

        star.addEventListener('mouseout', function() {
            const checkedStar = document.querySelector('.star-rating input[type="radio"]:checked');
            if (checkedStar) {
                const checkedIndex = Array.from(stars).indexOf(checkedStar.nextElementSibling);
                stars.forEach((s, i) => {
                    s.style.color = i <= checkedIndex ? '#f5b301' : '#ddd';
                });
            } else {
                stars.forEach(s => s.style.color = '#ddd');
            }
        });
    });

    starInputs.forEach((input, index) => {
        input.addEventListener('change', function() {
            stars.forEach((star, i) => {
                star.style.color = i < input.value ? '#f5b301' : '#ddd';
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', (event) => {
    const dateInput = document.getElementById('date');
    const timeSelect = document.getElementById('time');
    const numberSelect = document.getElementById('number');
    const paymentMethodSelect = document.getElementById('payment_method');

    const selectedDate = document.getElementById('selected-date');
    const selectedTime = document.getElementById('selected-time');
    const selectedNumber = document.getElementById('selected-number');
    const selectedPaymentMethod = document.getElementById('selected-payment_method');

    dateInput.addEventListener('change', () => {
        selectedDate.textContent = dateInput.value;
    });

    timeSelect.addEventListener('change', () => {
        selectedTime.textContent = timeSelect.value;
    });

    numberSelect.addEventListener('change', () => {
        selectedNumber.textContent = numberSelect.value + '人';
    });

    paymentMethodSelect.addEventListener('change', () => {
        selectedPaymentMethod.textContent = paymentMethodSelect.options[paymentMethodSelect.selectedIndex].text;
    });
});
</script>

</body>
</html>
