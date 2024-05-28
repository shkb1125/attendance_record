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

        {{-- @if (session('message'))
            <div>
                {{ session('message') }}
            </div>
        @endif --}}
    </div>
@endsection


{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success" role="alert">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
