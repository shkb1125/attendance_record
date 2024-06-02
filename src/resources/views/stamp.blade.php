@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
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
    <div class="stamp-panel">
        <h2 class="stamp-panel__heading content__heading">
            {{ $user->name }}さんお疲れ様です！
        </h2>
        <div class="stamp-panel__inner">

            <form class="stamp-panel__button" action="/attendance/start" method="POST">
                @csrf
                <button type="submit" class="stamp-panel__button-submit"
                    @if ($attendance && $attendance->start_time && !$attendance->end_time) disabled @endif>勤務開始</button>
            </form>
            <form class="stamp-panel__button" action="/attendance/end" method="POST">
                @csrf
                <button type="submit" class="stamp-panel__button-submit"
                    @if (!$attendance || !$attendance->start_time || $attendance->end_time) disabled @endif>勤務終了</button>
            </form>
            <form class="stamp-panel__button" action="/rest/start" method="POST">
                @csrf
                <button type="submit" class="stamp-panel__button-submit"
                    @if (
                        !$attendance ||
                            !$attendance->start_time ||
                            $attendance->end_time ||
                            ($attendance->rests->last() && !$attendance->rests->last()->rest_end_time)) disabled @endif>休憩開始</button>

            </form>
            <form class="stamp-panel__button" action="/rest/end" method="POST">
                @csrf
                <button type="submit" class="stamp-panel__button-submit"
                    @if (
                        !$attendance ||
                            !$attendance->start_time ||
                            $attendance->end_time ||
                            !$attendance->rests->last() ||
                            $attendance->rests->last()->rest_end_time) disabled @endif>休憩終了</button>
            </form>
        </div>
    </div>

    @if ($attendance && $attendance->end_time)
        <script>
            // 勤務終了ボタン押下→全てのボタン非活性
            var buttons = document.querySelectorAll('.stamp-panel__button-submit');
            buttons.forEach(function(button) {
                button.disabled = true;
            });
        </script>
    @endif
@endsection
