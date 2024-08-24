@extends('layouts.admin')

@section('title', 'ユーザー一覧')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endsection

@section('content')
    <div class="users-list-container">
        <h2 class="title">ユーザー一覧</h2>
        <table class="users-table">
            <thead>
                <tr>
                    <th class="user-header">ユーザー名</th>
                    <th class="action-header">口コミ一覧</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="user-name">{{ $user->name }}</td>
                        <td class="action-cell">
                            <a href="{{ route('admin.users.reviews', $user->id) }}" class="detail-button">
                                <i class="fa-regular fa-comment"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection