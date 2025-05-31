@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/post/post.css') }}">
<link rel="stylesheet" href="{{ asset('css/post/show.css') }}">
@endsection

@section('content')
    <div class="blog-detail-container">
        <h2 class="blog-detail-title">{{ $post->title }}</h2>
        <div class="blog-detail-author" >
            @if($post->user && $post->user->avatar)
                <img src="{{ asset('storage/' . $post->user->avatar) }}"
                        alt="{{ $post->user->name }}"
                        width="32" height="32"
                        class="blog-detail-avatar">
            @else
                <img src="{{ asset('images/default-user.png') }}"
                        alt="No Image"
                        width="32" height="32"
                        class="blog-detail-avatar">
            @endif
            <span class="blog-detail-author-name">{{ $post->user->name ?? '不明なユーザー' }}</span>
        </div>
        <div class="blog-detail-tags">
            @include('posts.partials.tag_buttons', ['post' => $post])
        </div>
        <div class="blog-detail-meta">
            投稿日時: {{ $post->created_at->format('Y-m-d H:i') }}
        </div>
        <div class="blog-detail-body">
            {!! nl2br(e($post->body)) !!}
        </div>
        @if (Auth::user()->role === 'admin')
            <div class="blog-detail-admin-actions">
                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-secondary">{{ __('messages.Edit Post') }}</a>
            </div>
        @endif

        {{-- コメント投稿フォーム：ログインユーザーのみ --}}
        @auth
            <div class="blog-detail-comment-form mt-4">
                <form action="{{ route('comments.store', $post->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="comment-content">コメントを投稿する</label>
                        <textarea name="content" id="comment-content" class="form-control" rows="3" required>{{ old('content') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">コメントする</button>
                </form>
            </div>
        @endauth

        {{-- コメント一覧 --}}
        @if($post->comments->count())
            <div class="blog-detail-comments mt-4">
                <h3 class="blog-detail-comments-title">コメント</h3>
                <ul class="blog-detail-comments-list">
                    @foreach($post->comments as $comment)
                        <li class="blog-detail-comment-item d-flex align-items-start mb-2">
                            <div class="blog-detail-comment-avatar">
                                @if($comment->user && $comment->user->avatar)
                                    <img src="{{ asset('storage/' . $comment->user->image) }}" alt="{{ $comment->user->name }}" width="40" height="40" class="rounded-circle">
                                @else
                                    <img src="{{ asset('images/default-user.png') }}" alt="No Image" width="40" height="40" class="rounded-circle">
                                @endif
                            </div>
                            <div>
                                <span class="blog-detail-comment-user"><strong>{{ $comment->user->name ?? '不明なユーザー' }}</strong></span>
                                <span class="blog-detail-comment-date">{{ $comment->created_at->format('Y-m-d H:i') }}</span>
                                <div class="blog-detail-comment-content">{{ $comment->content }}</div>
                                    @can('update', $comment)
                                        <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-link">編集</a>
                                    @endcan

                                    @can('delete', $comment)
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-link text-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
                                        </form>
                                    @endcan
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection