@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/schedule/schedule.css') }}">
@endsection

@section('content')
<div class="schedule-container">
    <h2>{{ $year }}年{{ $month }}月のスケジュール</h2>
    <div class="calendar-controls">
        <a href="{{ route('schedule.show', ['year' => $month == 1 ? $year-1 : $year, 'month' => $month == 1 ? 12 : $month-1]) }}">前月</a>
        <a href="{{ route('schedule.create') }}" class="btn btn-primary">イベント追加</a>
        <a href="{{ route('schedule.show', ['year' => $month == 12 ? $year+1 : $year, 'month' => $month == 12 ? 1 : $month+1]) }}">次月</a>
    </div>

    @php
    function cuttitle($title) {
        return mb_strimwidth($title, 0, 20, '…', 'UTF-8');
    }
    @endphp

    <table class="calendar">
        <thead>
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($days); $i += 7)
            <tr>
                @for ($j = 0; $j < 7; $j++)
                    @php
                        $date = $days[$i + $j];
                        $dateStr = $date->toDateString();
                        $evs = isset($events[$dateStr]) ? $events[$dateStr] : [];
                        $evArr = [];
                        foreach ($evs as $ev) {
                            $evArr[] = [
                                'id' => $ev->id,
                                'title' => cuttitle($ev->title),
                                'time' => \Carbon\Carbon::parse($ev->date)->format('H:i'),
                                'detail_url' => route('schedule.detail', $ev),
                            ];
                        }
                    @endphp
                    <td class="{{ $date->month !== $month ? 'calendar-other-month' : '' }}"
                        data-events='@json($evArr)'
                        data-date="{{ $dateStr }}"
                        style="position:relative;">
                        <div>{{ $date->day }}</div>
                        @if(count($evArr))
                            <span class="has-event"></span>
                        @endif
                    </td>
                @endfor
            </tr>
        @endfor
        </tbody>
    </table>
    <div id="event-popup" style="display:none;"></div>
</div>
@endsection