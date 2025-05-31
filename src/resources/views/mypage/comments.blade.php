@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/mypage.css') }}">
@endsection

@section('content')
    <div>
        <h3 class="profile-title">自分のコメント一覧</h3>
    </div>

    @if($comments->count())
        <ul class="profile-comments-list">
            @foreach($comments as $comment)
                <li class="profile-comment-item" style="margin-bottom:1.5em;">
                    <a href="{{ route('posts.show', $comment->post->id) }}" 
                       style="text-decoration:none;color:inherit;display:block;">
                        <div class="comment-blog-title" style="font-weight:bold;">
                            {{ $comment->post->title ?? '投稿が見つかりません' }}
                        </div>
                        <div class="comment-content" style="margin-top:0.4em;">
                            {{ $comment->content }}
                        </div>
                        <div class="comment-date text-muted" style="font-size:0.85em;">
                            {{ $comment->created_at->format('Y-m-d H:i') }}
                        </div>
                        @if(auth()->user()->role === 'admin')
                            <div class="comment-user" style="font-size:0.9em;color:#666;">
                                ユーザー: {{ $comment->user->name ?? '不明なユーザー' }}
                            </div>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="mt-4">
            {{ $comments->links() }}
        </div>
    @else
        <div>コメントはありません。</div>
    @endif

    <div class="mt-4">
        <a href="{{ route('profile.show') }}" class="submit-btn">マイページへ戻る</a>
    </div>
@endsection