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
            <li><a href="/login" class="header__link">ログアウト</a></li>
        </ul>
    </nav>
@endsection

@section('content')
    <div class="attendance">
        <div class="attendance__heading content__heading">
            <a class="attendance__link" href="#">&lt;</a>
            <h2 class="attendance__heading-text">今日の日付</h2>
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
            <tr class="attendance__row">
                <td class="attendance__data">テスト太郎</td>
                <td class="attendance__data">10:00:00</td>
                <td class="attendance__data">20:00:00</td>
                <td class="attendance__data">00:30:00</td>
                <td class="attendance__data">09:30:00</td>
            </tr>
        </table>
        {{-- ページネーション --}}
    </div>
@endsection
