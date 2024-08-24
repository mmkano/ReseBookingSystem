@extends('layouts.common')

@section('title', $shop->name . '詳細情報')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
@endsection

@section('content')
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

                <div class="review-section">
                    <a href="{{ route('review.create', ['id' => $shop->id]) }}" class="review-link">口コミを投稿する</a>

                    @if(session('error'))
                        <div class="alert alert-danger mt-2">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>

                <h2 class="reviews-info">全ての口コミ情報</h2>

                @foreach($shop->reviews as $review)
                    <div class="review-actions">
                        @if(Auth::id() === $review->user_id)
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#editReviewModal" 
                                    data-review-id="{{ $review->id }}"
                                    data-review-rating="{{ $review->rating }}"
                                    data-review-comment="{{ $review->comment }}"
                                    data-review-image="{{ $review->image_url }}">
                                口コミを編集
                            </button>
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#deleteReviewModal" 
                                    data-review-id="{{ $review->id }}">
                                口コミを削除
                            </button>
                        @endif
                    </div>
                    <div class="review-item">
                        <strong>{{ $review->user->name }}</strong>
                        <div class="review-header">
                            <div class="review-rating">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $review->rating)
                                        <span style="color: #3f5fec;">&#9733;</span>
                                    @else
                                        <span style="color: #ddd;">&#9733;</span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <p>{{ $review->comment }}</p>
                        @if ($review->image_path)
                            <img src="{{ Storage::url($review->image_path) }}" alt="Review Image" style="max-width: 200px;">
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="reservation">
                <div class="reservation__inner">
                    <h2>予約</h2>
                    <form action="{{ route('reserve') }}" method="POST">
                        @csrf
                        <div class="booking-details">
                            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                            <input type="date" id="date" name="date" value="{{ old('date') }}">
                            @error('date')
                                <div class="error">{{ $message }}</div>
                            @enderror
                            <select id="time" name="time">
                                <option value="">選択してください</option>
                                @foreach ($times as $time)
                                    <option value="{{ $time }}" {{ old('time') == $time ? 'selected' : '' }}>{{ $time }}</option>
                                @endforeach
                            </select>
                            @error('time')
                                <div class="error">{{ $message }}</div>
                            @enderror
                            <select id="number" name="number">
                                <option value="">選択してください</option>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('number') == $i ? 'selected' : '' }}>{{ $i }}人</option>
                                @endfor
                            </select>
                            @error('number')
                                <div class="error">{{ $message }}</div>
                            @enderror
                            <select id="payment_method" name="payment_method" onchange="updatePaymentMethod()">
                                <option value="">選択してください</option>
                                <option value="onsite" {{ old('payment_method') == 'onsite' ? 'selected' : '' }}>現地決済</option>
                                <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>カード決済</option>
                            </select>
                            @error('payment_method')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="reservation-summary">
                            <p>Shop <span id="selected-shop">{{ $shop->name }}</span></p>
                            <p>Date <span id="selected-date">{{ old('date') }}</span></p>
                            <p>Time <span id="selected-time">{{ old('time') }}</span></p>
                            <p>Number <span id="selected-number">{{ old('number') }}</span></p>
                            <p>Payment <span id="selected-payment_method">{{ old('payment_method') }}</span></p>
                        </div>
                        <button type="submit">予約する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 口コミ編集用モーダル -->
    <div class="modal fade" id="editReviewModal" tabindex="-1" role="dialog" aria-labelledby="editReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editReviewModalLabel">口コミを編集する</h5>
                </div>
                <div class="modal-body">
                    @if(isset($review))
                        <form id="editReviewForm" method="POST" enctype="multipart/form-data" action="{{ route('review.update', ['id' => $review->id]) }}">
                            @csrf
                            @method('PUT')

                            <div class="rating">
                                <label for="editRating" class="rating-label">体験を評価してください</label>
                                <div id="editRating" class="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" value="{{ $i }}" id="edit-{{ $i }}-stars">
                                        <label for="edit-{{ $i }}-stars" class="star">&#9733;</label>
                                    @endfor
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="editComment" class="review">口コミを編集</label>
                                <textarea id="editComment" name="comment" rows="4" maxlength="400"></textarea>
                                <div class="char-count">0/400 (最高文字数)</div>
                            </div>

                            <div class="form-group">
                                <label for="editImage" class="image">画像の編集</label>
                                <div class="image-upload-instructions">
                                    <input type="file" id="editImage" name="image" accept="image/jpeg,image/png" onchange="handleEditFileSelect(event)" style="display: none;">
                                    <label for="editImage" id="edit-upload-label" class="custom-file-upload">
                                        クリックして写真を追加<br>またはドラッグアンドドロップ
                                    </label>
                                    <div id="existingImageContainer" class="existingImageContainer" style="margin-top: 10px;">
                                        <img id="existingImage" src="" alt="Current Review Image" style="max-width: 100%; display: none;">
                                        <button type="button" id="removeImageButton" class="btn btn-danger btn-sm" style="display: none;">画像を削除</button>
                                    </div>
                                    <div id="edit-file-name" style="margin-top: 10px;"></div>
                                    @error('image')
                                        <div id="error" class="error" style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                            <button type="submit" form="editReviewForm" class="btn btn-primary">保存する</button>
                        </form>
                    @else
                        <p>レビューがありません。</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 口コミ削除確認用モーダル -->
    <div class="modal fade" id="deleteReviewModal" tabindex="-1" role="dialog" aria-labelledby="deleteReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteReviewModalLabel">口コミを削除</h5>
                </div>
                <div class="modal-body">
                    本当にこの口コミを削除しますか？
                </div>
                <div class="modal-footer">
                    <form id="deleteReviewForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">戻る</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#editReviewModal').modal('show');
            });
        </script>
    @endif

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date');
            const timeSelect = document.getElementById('time');
            const numberSelect = document.getElementById('number');
            const paymentMethodSelect = document.getElementById('payment_method');

            const selectedDate = document.getElementById('selected-date');
            const selectedTime = document.getElementById('selected-time');
            const selectedNumber = document.getElementById('selected-number');
            const selectedPaymentMethod = document.getElementById('selected-payment_method');

            if (dateInput) {
                dateInput.addEventListener('change', () => {
                    selectedDate.textContent = dateInput.value;
                });
            }

            if (timeSelect) {
                timeSelect.addEventListener('change', () => {
                    selectedTime.textContent = timeSelect.value;
                });
            }

            if (numberSelect) {
                numberSelect.addEventListener('change', () => {
                    selectedNumber.textContent = numberSelect.value + '人';
                });
            }

            if (paymentMethodSelect) {
                paymentMethodSelect.addEventListener('change', () => {
                    selectedPaymentMethod.textContent = paymentMethodSelect.options[paymentMethodSelect.selectedIndex].text;
                });
            }

            $('#editReviewModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const reviewId = button.data('review-id');
                const reviewRating = button.data('review-rating');
                const reviewComment = button.data('review-comment');
                const reviewImage = button.data('review-image');

                const modal = $(this);
                modal.find('#editReviewForm').attr('action', '/review/' + reviewId);

                const stars = modal.find('.star-rating .star');
                const starInputs = modal.find('.star-rating input[type="radio"]');

                starInputs.prop('checked', false);
                starInputs.filter(`[value="${reviewRating}"]`).prop('checked', true);

                stars.each(function(index) {
                    $(this).css('color', index < reviewRating ? '#3f5fec' : '#ddd');
                });

                stars.each(function(index) {
                    const star = $(this);

                    star.on('click', function() {
                        const rating = index + 1;
                        starInputs.each(function(i) {
                            $(this).prop('checked', i === index);
                            stars.eq(i).css('color', i <= index ? '#3f5fec' : '#ddd');
                        });
                    });

                    star.on('mouseover', function() {
                        stars.each(function(i) {
                            $(this).css('color', i <= index ? '#3f5fec' : '#ddd');
                        });
                    });

                    star.on('mouseout', function() {
                        const checkedStar = modal.find('.star-rating input[type="radio"]:checked');
                        if (checkedStar.length > 0) {
                            const checkedIndex = starInputs.index(checkedStar);
                            stars.each(function(i) {
                                $(this).css('color', i <= checkedIndex ? '#3f5fec' : '#ddd');
                            });
                        } else {
                            stars.css('color', '#ddd');
                        }
                    });
                });

                modal.find('#editComment').val(reviewComment);

                if (reviewImage) {
                    modal.find('#existingImage').attr('src', reviewImage).show();
                    modal.find('#removeImageButton').show();
                    modal.find('#edit-upload-label').hide();
                } else {
                    modal.find('#existingImage').hide();
                    modal.find('#removeImageButton').hide();
                    modal.find('#edit-upload-label').show();
                }
            });

            const imageInput = document.getElementById('editImage');
            const imagePreview = document.getElementById('existingImage');
            const removeImageButton = document.getElementById('removeImageButton');
            const uploadLabel = document.getElementById('edit-upload-label');
            const deleteImageInput = document.createElement('input');

            deleteImageInput.setAttribute('type', 'hidden');
            deleteImageInput.setAttribute('name', 'delete_image');
            deleteImageInput.setAttribute('value', '0');

            document.getElementById('editReviewForm').appendChild(deleteImageInput);

            if (imageInput) {
                imageInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];

                    if (file && file.type.match('image.*')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';
                            removeImageButton.style.display = 'block';
                            deleteImageInput.value = '0';
                            uploadLabel.style.display = 'none';
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            if (!existingImage.src || existingImage.src.endsWith('data:,')) {
                existingImageContainer.style.display = 'none';
            } else {
                existingImage.style.display = 'block';
                removeImageButton.style.display = 'block';
                uploadLabel.style.display = 'none';
            }

            removeImageButton.addEventListener('click', function() {
                imagePreview.style.display = 'none';
                removeImageButton.style.display = 'none';
                imageInput.value = '';
                uploadLabel.style.display = 'block';
                deleteImageInput.value = '1';
            });

            $('#deleteReviewModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const reviewId = button.data('review-id');

                const modal = $(this);
                modal.find('#deleteReviewForm').attr('action', '/review/' + reviewId);
            });

            $('#editReviewModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const reviewImage = button.data('review-image');
                const imagePreview = document.getElementById('existingImage');
                const removeImageButton = document.getElementById('removeImageButton');
                const uploadLabel = document.getElementById('edit-upload-label');

                if (reviewImage && reviewImage !== '/storage/') {
                    imagePreview.src = reviewImage;
                    imagePreview.style.display = 'block';
                    removeImageButton.style.display = 'block';
                    uploadLabel.style.display = 'none';
                } else {
                    imagePreview.src = '';
                    imagePreview.style.display = 'none';
                    removeImageButton.style.display = 'none';
                    uploadLabel.style.display = 'block';
                }
            });
        });
    </script>
@endsection