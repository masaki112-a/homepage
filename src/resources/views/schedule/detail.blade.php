@extends('layouts.app')

@section('content')
<div class="schedule-container">
    <h2>イベント詳細</h2>
    <div>
        <strong>タイトル:</strong> {{ $event->title }}
    </div>
    <div>
        <strong>日付:</strong> {{ $event->date }}
    </div>
    <div>
        <strong>内容:</strong> {!! nl2br(e($event->description)) !!}
    </div>
    <div style="margin-top:1em;">
        <a href="{{ route('schedule.edit', $event) }}" class="btn btn-primary">編集</a>
        <form action="{{ route('schedule.destroy', $event) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('本当に削除しますか？');" class="btn btn-danger">削除</button>
        </form>
        <a href="{{ route('schedule.show') }}">スケジュールへ戻る</a>
    </div>
</div>
@endsection