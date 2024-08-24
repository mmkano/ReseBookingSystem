@extends('layouts.admin')

@section('title', $user->name . 'の口コミ一覧')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/user_reviews.css') }}">
@endsection

@section('content')
    <div class="user-reviews-container">
        <div class="user-info">
            <h3>{{ $user->name }}</h3>
        </div>
        <hr>
        <h5>コメント一覧</h5>
        @if($reviews->isEmpty())
            <p>コメントがありません。</p>
        @else
            <table class="reviews-table">
                <thead>
                    <tr>
                        <th>店舗名</th>
                        <th>口コミ日時</th>
                        <th>コメント</th>
                        <th>星評価</th>
                        <th>画像</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td>{{ $review->shop->name }}</td>
                            <td>{{ $review->created_at }}</td>
                            <td>{{ $review->comment }}</td>
                            <td>
                                <div class="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <i class="fas fa-star text-warning" style="color: #FFD700;"></i>
                                        @else
                                            <i class="fas fa-star text-muted" style="color: #ddd;"></i>
                                        @endif
                                    @endfor
                                </div>
                            </td>
                            <td>
                                @if($review->image_path)
                                    <img src="{{ $review->image_path }}" alt="Review Image" style="max-width: 100px;">
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
