@extends('layouts.appCenter')

@section('header')
    Reset Password
@endsection

@section('main')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="control-label">E-Mail Address</label>
 
            <div class="">
                <input id="email" type="email" class="form-control" name="email" placeholder="your email address" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="">
                <button type="submit" class="btn theme-btn">
                    Send Password Reset Link
                </button>
            </div>
        </div>
    </form>
@endsection
