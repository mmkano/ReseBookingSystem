@extends('layouts.common')

@section('title', '口コミ投稿')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/review_create.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection

@section('content')
    <div class="review-container">
        <div class="review-content">

            <div class="shop-card">
                <h2>今回のご利用はいかがでしたか？</h2>
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
            </div>

            <div class="vertical-line"></div>

            <div class="review-form">
                <form action="{{ route('review.store', ['shopId' => $shop->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="rating">
                        <label for="rating" class="rating-label">体験を評価してください</label>
                        <div id="rating" class="star-rating">
                            <input type="radio" name="rating" value="1" id="1-stars">
                            <label for="1-stars" class="star">&#9733;</label>
                            <input type="radio" name="rating" value="2" id="2-stars">
                            <label for="2-stars" class="star">&#9733;</label>
                            <input type="radio" name="rating" value="3" id="3-stars">
                            <label for="3-stars" class="star">&#9733;</label>
                            <input type="radio" name="rating" value="4" id="4-stars">
                            <label for="4-stars" class="star">&#9733;</label>
                            <input type="radio" name="rating" value="5" id="5-stars">
                            <label for="5-stars" class="star">&#9733;</label>
                        </div>
                        @error('rating')
                            <div class="error" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="review" class="review">口コミを投稿</label>
                        <textarea id="comment" name="comment" rows="4" maxlength="400" placeholder="カジュアルな夜のお出かけにおすすめのスポット"></textarea>
                        <div class="char-count">0/400 (最高文字数)</div>
                        @error('comment')
                            <div class="error" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image" class="image">画像の追加</label>
                        <div class="image-upload-instructions">
                            <input type="file" id="image" name="image" onchange="handleFileSelect(event)" style="display: none;">
                            <label for="image" id="upload-label" class="custom-file-upload">
                                クリックして写真を追加<br>またはドラッグアンドドロップ
                            </label>
                            <div id="file-name" style="margin-top: 10px;"></div>
                        </div>
                        @error('image')
                            <div class="error" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="submit-btn">口コミを投稿</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-rating .star');
            const starInputs = document.querySelectorAll('.star-rating input[type="radio"]');

            stars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    const rating = index + 1;
                    starInputs.forEach((input, i) => {
                        input.checked = i === index;
                        stars[i].style.color = i <= index ? '#3f5fec' : '#ddd';
                    });
                });

                star.addEventListener('mouseover', function() {
                    stars.forEach((s, i) => {
                        s.style.color = i <= index ? '#3f5fec' : '#ddd';
                    });
                });

                star.addEventListener('mouseout', function() {
                    const checkedStar = document.querySelector('.star-rating input[type="radio"]:checked');
                    if (checkedStar) {
                        const checkedIndex = Array.from(starInputs).indexOf(checkedStar);
                        stars.forEach((s, i) => {
                            s.style.color = i <= checkedIndex ? '#3f5fec' : '#ddd';
                        });
                    } else {
                        stars.forEach(s => s.style.color = '#ddd');
                    }
                });
            });

            const textarea = document.getElementById('comment');
            const charCount = document.querySelector('.char-count');

            textarea.addEventListener('input', () => {
                charCount.textContent = `${textarea.value.length}/400`;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const output = document.getElementById('file-name');
            const uploadLabel = document.getElementById('upload-label');

            imageInput.addEventListener('change', function(event) {
                const files = event.target.files;
                output.innerHTML = '';

                if (files.length > 0) {
                    uploadLabel.style.display = 'none';
                }

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    if (!file.type.match('image.*')) {
                        continue;
                    }

                    const reader = new FileReader();

                    reader.onload = (function(theFile) {
                        return function(e) {
                            const span = document.createElement('span');
                            span.innerHTML = ['<img class="thumb" src="', e.target.result, '" title="', escape(theFile.name), '" style="max-width: 200px; margin-top: 10px;"/>'].join('');
                            output.insertBefore(span, null);
                        };
                    })(file);

                    reader.readAsDataURL(file);
                }
            });

            function handleFileSelect(event) {
                const input = event.target;
                const fileName = input.files.length > 0 ? input.files[0].name : "選択されていません";
                const fileNameDisplay = document.getElementById('file-name');
                fileNameDisplay.textContent = fileName;

                if (input.files.length > 0) {
                    uploadLabel.style.display = 'none';
                }
            }

            const favoriteForms = document.querySelectorAll('.action-container form');

    favoriteForms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const actionUrl = form.getAttribute('action');
            const formData = new FormData(form);

            fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'liked' || data.status === 'unliked') {
                    window.location.reload();
                } else {
                    alert('エラーが発生しました。再試行してください。');
                }
            })
            .catch(error => {
                console.error('エラー:', error);
                alert('エラーが発生しました。再試行してください。');
            });
        });
    });

        });
    </script>
@endsection
