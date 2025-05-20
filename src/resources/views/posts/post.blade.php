@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance__content">
  @foreach ($posts as $post)
      <h2><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>
      <p>{{ Str::limit($post->body, 100) }}</p>
  @endforeach

  {{ $posts->links() }}

  @auth
      <a href="{{ route('posts.create') }}">新規投稿</a>
  @endauth
</div>
@endsection