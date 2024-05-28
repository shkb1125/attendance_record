@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('link')
    <nav class="header__nav">
        <ul>
            <li><a href="/" class="header__link">ホーム</a></li>
            <li><a href="/attendance" class="header__link">日付一覧</a></li>
            <li>
                <form class="logout-form" action="/logout" method="post">
                    @csrf
                    <button class="header__link" type="submit">ログアウト</button>
                </form>
            </li>
        </ul>
    </nav>
@endsection

@section('content')
    <div class="attendance">
        <div class="attendance__heading content__heading">
            <a class="attendance__link" href="{{ route('attendance.show', ['date' => $yesterdayDate]) }}">&lt;</a>
            <h2 class="attendance__heading-text">{{ $date->format('Y-m-d') }}</h2>
            <a class="attendance__link" href="{{ route('attendance.show', ['date' => $nextDate]) }}">&gt;</a>
        </div>
        <table class="attendance__table">
            <tr class="attendance__row">
                <th class="attendance__label">名前</th>
                <th class="attendance__label">勤務開始</th>
                <th class="attendance__label">勤務終了</th>
                <th class="attendance__label">休憩時間</th>
                <th class="attendance__label">勤務時間</th>
            </tr>

            @foreach ($attendances as $attendance)
                <tr class="attendance__row">
                    <td class="attendance__data">{{ $attendance->user->name }}</td>
                    <td class="attendance__data">{{ $attendance->start_time }}</td>
                    <td class="attendance__data">{{ $attendance->end_time }}</td>
                    <td class="attendance__data">{{ $attendance->total_rest_time }}</td>
                    <td class="attendance__data">{{ $attendance->total_work_time }}</td>
                </tr>
            @endforeach

        </table>
        {{-- ページネーション --}}
        {{ $attendances->links('vendor.pagination.custom') }}
    </div>
@endsection
