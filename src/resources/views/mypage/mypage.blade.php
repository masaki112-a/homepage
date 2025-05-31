@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/mypage.css') }}">
@endsection

@section('content')
    <div>
        <h3 class="profile-title">{{ __('messages.Profile Information') }}</h3>
    </div>
    <!-- 新しい横並びレイアウト -->
    <div class="profile-main-flex">
        <div class="profile-info-block">
            <div>
                <label class="profile-view-label">{{ __('messages.Account Type') }}</label>
                <div class="profile-account-typ">
                    {{ ucfirst(auth()->user()->role) }} {{ __('messages.User') }}
                </div>
            </div>
            <div>
                <label class="profile-view-label">{{ __('messages.Name') }}</label>
                <div class="profile-view-value">{{ auth()->user()->name }}</div>
            </div>
            <div>
                <label class="profile-view-label">{{ __('messages.Email') }}</label>
                <div class="profile-view-value">{{ auth()->user()->email }}</div>
            </div>
        </div>
        <div class="profile-avatar-side">
            @if (auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                    alt="{{ auth()->user()->name }}"
                    class="profile-avatar-img">
            @endif
        </div>
    </div>
    <!-- Bioをその下に配置 -->
    <div>
        <label class="profile-view-label">{{ __('messages.Bio') }}</label>
        <div class="profile-view-value">{{ auth()->user()->bio }}</div>
    </div>
    
    <div class="profile-stats">  
        <a href="{{ route('profile.comments') }}" style="text-decoration: none; color: inherit;">
                <div class="profile-stat-card" style="cursor: pointer;">
                    <div class="profile-stat-title">自分のコメント数</div>
                    <div class="profile-stat-value">
                        {{ $myCommentCount ?? auth()->user()->comments()->count() }}
                    </div>
                </div>
        </a>
        @if(auth()->user()->role === 'admin')
            <div class="profile-stat-card">
                <div class="profile-stat-title">他ユーザーのコメント数</div>
                <div class="profile-stat-value">
                    {{ $otherCommentCount ?? \App\Models\Comment::where('user_id', '!=', auth()->id())->count() }}
                </div>
            </div>
        @endif
        <div class="profile-stat-card">
            <div class="profile-stat-title">{{ __('messages.Member Since') }}</div>
            <div class="profile-stat-value">
                {{ auth()->user()->created_at->format('M d, Y') }}
            </div>
        </div>
        <div class="profile-stat-card">
            <div class="profile-stat-title">{{ __('messages.Last Updated') }}</div>
            <div class="profile-stat-value">
                {{ auth()->user()->updated_at->format('M d, Y H:i') }}
            </div>
        </div>
        <a href="{{ route('profile.favorites') }}" style="text-decoration: none; color: inherit;">
            <div class="profile-stat-card" style="cursor: pointer;">
                <div class="profile-stat-title">お気に入り</div>
                <div class="profile-stat-value">{{ $favoriteCount }}</div>
            </div>
        </a>
        <a href="{{ route('profile.watch_later') }}" style="text-decoration: none; color: inherit;">
            <div class="profile-stat-card" style="cursor: pointer;">
                <div class="profile-stat-title">後で閲覧</div>
                <div class="profile-stat-value">{{ $readLaterCount }}</div>
            </div>
        </a>
    </div>
    <div class="flex items-center justify-end pt-6">
        <a href="{{ route('profile.edit') }}" class="submit-btn">
            {{ __('messages.Edit Profile') }}
        </a>
    </div>
    <div class="password-change-section">
    <a href="{{ route('password.reset.form') }}" class="submit-btn">
        {{ __('messages.Change Password') }}
    </a>
    </div>
@endsection