@extends('layouts.app')

@section('content')
<div class="container">
    <h3>コメント編集</h3>
    <form method="POST" action="{{ route('comments.update', $comment->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <textarea name="content" class="form-control" rows="3" required>{{ old('content', $comment->content) }}</textarea>
        </div>
        <button type="submit" class="btn btn-success mt-2">更新</button>
        <a href="{{ route('posts.show', $comment->post_id) }}" class="btn btn-secondary mt-2">キャンセル</a>
    </form>
</div>
@endsection