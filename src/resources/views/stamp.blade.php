@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
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
    <div class="stamp-panel">
        <h2 class="stamp-panel__heading content__heading">
            {{ $user->name }}さんお疲れ様です！
        </h2>
        <div class="stamp-panel__inner">

            <form class="stamp-panel__button" action="/attendance/start" method="POST">
                @csrf
                {{-- <button type="submit" class="stamp-panel__button-submit"
                    @if (($attendance && $attendance->start_time) || !$attendance->end_time) disabled @endif>勤務開始
                </button> --}}

                <button type="submit" class="stamp-panel__button-submit"
                    @if ($attendance && $attendance->start_time && !$attendance->end_time) disabled @endif>勤務開始</button>

                {{-- <button type="submit" class="stamp-panel__button-submit"
                    @if ($attendance && ($attendance->end_time || !$attendance->start_time)) disabled @endif>勤務開始</button> --}}

            </form>
            {{-- <form class="stamp-panel__button" action="/attendance/end" method="POST" id="endForm"> --}}
            <form class="stamp-panel__button" action="/attendance/end" method="POST">
                @csrf
                <button type="submit" class="stamp-panel__button-submit"
                    @if (!$attendance || !$attendance->start_time || $attendance->end_time) disabled @endif>勤務終了</button>
            </form>
            <form class="stamp-panel__button" action="/rest/start" method="POST">
                @csrf
                {{-- <button type="submit" class="stamp-panel__button-submit"
                    {{ !$attendance || !$attendance->start_time || $attendance->end_time ? 'disabled' : '' }}>休憩開始</button> --}}

                {{-- <button type="submit" class="stamp-panel__button-submit"
                    @if (!$attendance || !$attendance->start_time || $attendance->end_time) disabled @endif>休憩開始</button> --}}

                {{-- 下のif文と同一条件の三項演算子 --}}
                {{-- <button type="submit" class="stamp-panel__button-submit"
                    {{ !$attendance || !$attendance->start_time || $attendance->end_time || ($attendance->rests->last() && !$attendance->rests->last()->rest_end_time) ? 'disabled' : '' }}>休憩開始</button> --}}

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

                {{-- <button type="submit" class="stamp-panel__button-submit"
                    {{ !$attendance || !$attendance->start_time || !$attendance->end_time ? 'disabled' : '' }}>休憩終了</button> --}}
            </form>
        </div>
    </div>

    @if ($attendance && $attendance->end_time)
        <script>
            // 勤務終了ボタンがクリックされたとき、全てのボタンを非活性にする
            var buttons = document.querySelectorAll('.stamp-panel__button-submit');
            buttons.forEach(function(button) {
                button.disabled = true;
            });
        </script>
    @endif
@endsection
