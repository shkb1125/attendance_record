@extends('layouts.app')

@section('content')
    <div>
        <h1>送信されたメールを確認してください</h1>
        <p>Please check your email for a verification link.</p>
        <p>メールが届かない場合は、再送信のボタンを押してください</p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">再送信</button>
        </form>

    </div>
@endsection