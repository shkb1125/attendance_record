@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('link')
    <nav class="header__nav">
        <ul>
            <li><a href="/" class="header__link">ホーム</a></li>
            <li><a href="/attendance" class="header__link">日付一覧</a></li>
            {{-- fortify導入後、リンク先変更予定 --}}
            <li>
                <form class="form" action="/logout" method="post">
                    @csrf
                    <button class="header__link">ログアウト</button>
                </form>
            </li>
        </ul>
    </nav>
@endsection

@section('content')
    <div class="attendance">
        <div class="attendance__heading content__heading">
            <a class="attendance__link" href="#">&lt;</a>
            <h2 class="attendance__heading-text">{{ $date }}</h2>
            <a class="attendance__link" href="#">&gt;</a>
        </div>
        <table class="attendance__table">
            <tr class="attendance__row">
                <th class="attendance__label">名前</th>
                <th class="attendance__label">勤務開始</th>
                <th class="attendance__label">勤務終了</th>
                <th class="attendance__label">休憩時間</th>
                <th class="attendance__label">勤務時間</th>
            </tr>
            @foreach ($users as $user)
                @foreach ($user->attendances as $attendance)
                    <tr class="attendance__row">
                        <td class="attendance__data">{{ $user->name }}</td>
                        <td class="attendance__data">{{ $attendance->start_time }}</td>
                        <td class="attendance__data">{{ $attendance->end_time }}</td>
                        <td class="attendance__data">{{ $attendance->rests->first()->getTotalRestTime($attendance->id) }}</td>
                        <td class="attendance__data">{{ $attendance->getTotalWorkTime() }}</td>
                    </tr>
                @endforeach
            @endforeach
            {{-- <tr class="attendance__row">
                <td class="attendance__data">{{ $user->name }}</td>
                <td class="attendance__data">{{ $attendance ? $attendance->start_time : '-' }}</td>
                <td class="attendance__data">{{ $attendance ? $attendance->end_time : '-' }}</td>
                <td class="attendance__data">{{ $rest }}</td>
                <td class="attendance__data">{{ $totalWorkTime }}</td>
            </tr> --}}
        </table>
        {{-- ページネーション --}}
    </div>
@endsection