<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function show(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $dt = Carbon::create($year, $month, 1);
        $startOfMonth = $dt->copy()->startOfMonth();
        $endOfMonth = $dt->copy()->endOfMonth();
        $startCalendar = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $endCalendar = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);

        $days = [];
        $current = $startCalendar->copy();
        while ($current <= $endCalendar) {
            $days[] = $current->copy();
            $current->addDay();
        }

        // ログインユーザーの当月イベント取得
        $events = Event::where('user_id', Auth::id())
            ->whereBetween('date', [$startCalendar->toDateString(), $endCalendar->toDateString()])
            ->get()
            ->groupBy('date');

        return view('schedule.schedule', [
            'year' => $year,
            'month' => $month,
            'days' => $days,
            'events' => $events,
            'startCalendar' => $startCalendar,
            'endCalendar' => $endCalendar,
            'startOfMonth' => $startOfMonth,
            'endOfMonth' => $endOfMonth,
        ]);
    }

    public function create()
    {
        return view('schedule.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Event::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('schedule.show')->with('success', 'イベントを登録しました');
    }

    // イベント詳細
    public function detail(Event $event)
    {
        $this->authorize('view', $event);
        return view('schedule.detail', compact('event'));
    }

    // 編集画面
    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        return view('schedule.edit', compact('event'));
    }

    // 編集保存
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $event->update($request->only(['title', 'date', 'description']));

        return redirect()->route('schedule.detail', $event)->with('success', 'イベントを更新しました');
    }

    // 削除
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();
        return redirect()->route('schedule.show')->with('success', 'イベントを削除しました');
    }
}