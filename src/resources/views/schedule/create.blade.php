@extends('layouts.app')

@section('content')
<div class="schedule-container">
    <h2>イベント登録</h2>
    <form method="POST" action="{{ route('schedule.store') }}">
        @csrf
        <div>
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required>
        </div>
        <div>
            <label for="date">日付</label>
            <input type="date" name="date" id="date" value="{{ old('date') }}" required>
        </div>
        <div>
            <label for="description">内容</label>
            <textarea name="description" id="description">{{ old('description') }}</textarea>
        </div>
        <button type="submit">登録</button>
    </form>
    <a href="{{ route('schedule.show') }}">スケジュールへ戻る</a>
</div>
@endsection