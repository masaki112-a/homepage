@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/post/post.css') }}">
<link rel="stylesheet" href="{{ asset('css/post/create.css') }}">
<link rel="stylesheet" href="{{ asset('css/post/edit.css') }}">
@endsection

@section('content')
    <div class="edit-post-page">
        <div class="edit-post-container">
            <div class="edit-post-card">
                <h2 class="post-edit-title">{{ __('messages.Post') }}{{ __('messages.Edit') }}</h2>

                @if ($errors->any())
                    <div class="alert edit-post-error">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif

                <div class="edit-post-card-body">
                    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" class="edit-post-form">
                        @csrf
                        @method('PUT')
                        <div class="edit-post-form-group">
                            <label for="title" class="edit-post-label">タイトル</label>
                            <input type="text" name="title" id="title" class="edit-post-input" value="{{ old('title', $post->title) }}" required maxlength="255">
                        </div>
                        <div class="edit-post-form-group">
                            <label for="body" class="edit-post-label">本文</label>
                            <textarea name="body" id="body" class="edit-post-textarea" rows="8" required>{{ old('body', $post->body) }}</textarea>
                        </div>
                        <div class="edit-post-form-actions">
                            <button type="submit" class="edit-post-submit-btn">更新</button>
                        </div>
                    </form>

                    <form action="{{ route('admin.cd clinicposts.destroy', $post->id) }}" method="POST" class="edit-post-delete-form" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="edit-post-delete-btn">削除</button>
                    </form>

                    <div class="edit-post-back-link">
                        <a href="{{ route('posts.index') }}" class="edit-post-back-btn">一覧に戻る</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection