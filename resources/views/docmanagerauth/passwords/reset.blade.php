@extends('layouts.layout')

@section('header')
    @include('layouts.navbar')
@endsection

@section('content')
    <div class="container" id="dm-login-page">

        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form" role="form" method="POST" action="{{ url('/password/reset') }}">
                    {{ csrf_field() }}

                    @if(session()->has('reset_email_sent') && session('reset_email_sent'))
                        You will receive an email with instructions on how to reset your password.
                    @else

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            Email
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-block dm-btn">
                            Reset Password
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
