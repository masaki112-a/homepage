@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/post/post.css') }}">
<link rel="stylesheet" href="{{ asset('css/post/create.css') }}">
@endsection

@section('content')
    <div class="create-post-page">
        <div class="create-post-container">
            <div class="create-post-card">
                <div class="create-post-card-body">
                    <form action="{{ route('admin.posts.store') }}" method="POST" class="create-post-form">
                        @csrf

                        <div class="create-post-form-group">
                            <label for="title" class="create-post-label">Title</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title') }}"
                                   class="create-post-input"
                                   required>
                            @error('title')
                                <p class="create-post-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="create-post-form-group">
                            <label for="content" class="create-post-label">Content</label>
                            <textarea name="content" 
                                      id="content" 
                                      rows="10"
                                      class="create-post-textarea"
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="create-post-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="published_at">公開日時（未入力の場合は即時公開）</label>
                            <input type="datetime-local" name="published_at" id="published_at" class="form-control" value="{{ old('published_at') }}">
                        </div>

                        <div class="create-post-form-actions">
                            <button type="submit" 
                                    class="create-post-submit-btn">
                                Create Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection