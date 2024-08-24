@extends('layouts.admin')

@section('title', '管理者ダッシュボード')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endsection

@section('content')
    <div class="dashboard-container">
        <div class="dashboard-item" onclick="location.href='{{ route('admin.users.list') }}'">
            <div class="dashboard-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="dashboard-text">
                <p>ユーザ一覧</p>
                <span>(口コミ削除)</span>
            </div>
        </div>
        <div class="dashboard-item" onclick="location.href='{{ route('admin.owners.create') }}'">
            <div class="dashboard-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="dashboard-text">
                <p>店舗代表者の作成</p>
            </div>
        </div>
        <div class="dashboard-item" onclick="location.href='{{ route('admin.shops.import') }}'">
            <div class="dashboard-icon">
                <i class="fas fa-file-csv"></i>
            </div>
            <div class="dashboard-text">
                <p>店舗情報の作成</p>
                <span>(csvインポート)</span>
            </div>
        </div>
    </div>
@endsection