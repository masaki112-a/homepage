@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/post/post.css') }}">
<link rel="stylesheet" href="{{ asset('css/post/show.css') }}">
@endsection

@section('content')
    <h2 class="post-list-title">投稿一覧</h2>

    <form method="GET" action="{{ route('posts.index') }}" class="post-search-form">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="キーワード検索" class="post-search-input">
        <button type="submit" class="btn btn-primary post-search-btn">検索</button>
    </form>

    @if (Auth::user()->role === 'admin')
        <div class="post-create-btn-wrapper">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary post-create-btn">投稿作成</a>
        </div>
    @endif

    @if (session('status'))
        <div class="alert post-status-alert">
            {{ session('status') }}
        </div>
    @endif

    @if ($posts->count())
        <ul class="post-list">
            @foreach ($posts as $post)
                @php
                    $isScheduled = $post->published_at && \Carbon\Carbon::parse($post->published_at)->isFuture();
                @endphp
                <li class="post-list-item{{ (Auth::user()->role === 'admin' && $isScheduled) ? ' post-scheduled' : '' }}">
                    <a href="{{ route('posts.show', $post->id) }}" class="post-link">
                        <div class="post-title">{{ $post->title }}</div>
                        <div class="post-user-info" style="display: flex; align-items: center; margin-bottom: 0.5em;">
                            @if($post->user && $post->user->avatar)
                                <img src="{{ asset('storage/' . $post->user->avatar) }}"
                                     alt="{{ $post->user->name }}"
                                     width="32" height="32"
                                     style="border-radius: 50%; object-fit: cover; margin-right: 8px;">
                            @else
                                <img src="{{ asset('images/default-user.png') }}"
                                     alt="No Image"
                                     width="32" height="32"
                                     style="border-radius: 50%; object-fit: cover; margin-right: 8px;">
                            @endif
                            <span style="font-size: 1em; color: #444;">{{ $post->user->name ?? '不明なユーザー' }}</span>
                        </div>
                        <div style="margin-bottom: 0.5em;">
                            @include('posts.partials.tag_buttons', ['post' => $post])
                        </div>
                        <div class="post-body">
                            {{
                                Str::limit(
                                    preg_replace('/\r\n|\r|\n/u', '', mb_substr($post->body, 0, mb_strpos($post->body, '。', mb_strpos($post->body, '。') !== false ? mb_strpos($post->body, '。', mb_strpos($post->body, '。') + 1) : 0) + 1)),
                                    100
                                )
                            }}
                        </div>
                        <div class="post-meta">
                            公開日時: {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('Y-m-d H:i') : $post->created_at->format('Y-m-d H:i') }}
                            @if (Auth::user()->role === 'admin' && $isScheduled)
                                <span style="color:#e67e22;font-weight:bold;">（予約投稿）</span>
                            @endif
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="pagination post-pagination">
            {{ $posts->links() }}
        </div>
    @else
        <p class="post-list-empty">投稿がありません。</p>
    @endif
@endsection