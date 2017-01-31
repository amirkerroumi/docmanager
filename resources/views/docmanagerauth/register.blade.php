@extends('layouts.layout')

@section('header')
    @include('layouts.navbar')
@endsection

@section('content')
    <div class="container" id="dm-login-page">

        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form" role="form" method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}

                    @if(session()->has('registered') && session('registered'))
                        You have been successfully registered. <a class="dm-link" href="{{ url('/login') }}">Log in here.</a>
                    @else
                        {{--Name--}}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            Name
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        {{--Email--}}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            Email
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>

                        {{--Password--}}
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            Password
                            <input id="password" type="password" class="form-control" name="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                        {{--Password Confirmation--}}
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            Password confirmation
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-block dm-btn">
                            Register
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
