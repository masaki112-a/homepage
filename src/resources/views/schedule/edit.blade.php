@extends('layouts.app')

@section('content')
<div class="schedule-container">
    <h2>イベント編集</h2>
    <form method="POST" action="{{ route('schedule.update', $event) }}">
        @csrf
        @method('PUT')
        <div>
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required>
        </div>
        <div>
            <label for="date">日付</label>
            <input type="date" name="date" id="date" value="{{ old('date', $event->date) }}" required>
        </div>
        <div>
            <label for="description">内容</label>
            <textarea name="description" id="description">{{ old('description', $event->description) }}</textarea>
        </div>
        <button type="submit">更新</button>
    </form>
    <a href="{{ route('schedule.detail', $event) }}">詳細へ戻る</a>
</div>
@endsection