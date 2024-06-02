@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('link')
    <nav class="header__nav">
        <ul>
            <li><a href="/" class="header__link">ホーム</a></li>
            <li><a href="/attendance" class="header__link">日付一覧</a></li>
            <li><a href="/users" class="header__link">社員一覧</a></li>
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
            <h2 class="attendance__heading-text">{{ $user->name }}さんの勤怠一覧</h2>
        </div>
        <table class="attendance__table">
            <tr class="attendance__row">
                <th class="attendance__label">日付</th>
                <th class="attendance__label">勤務開始</th>
                <th class="attendance__label">勤務終了</th>
                <th class="attendance__label">休憩時間</th>
                <th class="attendance__label">勤務時間</th>
            </tr>

            @foreach ($attendances as $attendance)
                <tr class="attendance__row">
                    <td class="attendance__data">{{ $attendance->date }}</td>
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
