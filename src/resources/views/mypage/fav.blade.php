@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/mypage.css') }}">
@endsection

@section('content')
    <h2>お気に入り投稿</h2>
    @if($posts->count())
        <ul>
        @foreach($posts as $post)
            <li>
                <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                <span style="color:#888;">{{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('Y-m-d H:i') : $post->created_at->format('Y-m-d H:i') }}</span>
            </li>
        @endforeach
        </ul>
        {{ $posts->links() }}
    @else
        <p>お気に入り投稿はありません。</p>
    @endif
@endsection