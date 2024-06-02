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
            <h2 class="attendance__heading-text">社員一覧</h2>
        </div>
        <table class="attendance__table">
            <tr class="attendance__row">
                <th class="attendance__label">名前</th>
                <th class="attendance__label">勤怠一覧</th>
            </tr>

            @foreach ($users as $user)
                <tr class="attendance__row">
                    <td class="attendance__data">{{ $user->name }}</td>
                    <td class="attendance__data">
                        <a href="{{ route('user.attendance', $user->id) }}" class="btn btn-primary">勤務詳細</a>
                    </td>
                </tr>
            @endforeach

        </table>
        {{-- ページネーション --}}
        {{ $users->links('vendor.pagination.custom') }}
    </div>
@endsection
