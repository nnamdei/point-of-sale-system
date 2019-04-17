
@extends('layouts.plain')

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="text-center my-3">
                        <h4 class="theme-color" id="brand">{{config('app.name')}}</h4>
                    </div>
                    <form  method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                            @if ($errors->has('email'))
                                <div class="text-danger text-center">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            
                            @if ($errors->has('password'))
                                <div class="text-danger text-center">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email"  required autofocus>
                                <input id="password" type="password" class="form-control" name="password" placeholder="password"  required>
                            </div> 

                           
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remember-me" name="remember" {{ old('remember') ? 'checked' : '' }} value="true">
                                <label class="custom-control-label" for="remember-me">  Stay logged in</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-block theme-btn">
                            <i class="fa fa-sign-in-alt"></i>  Login
                            </button>
                        </div>

                        <div class="text-right">
                            <a href="{{ route('password.request') }}"> Forgot Your Password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <style>
        .card-body{
            border-radius: 10px;
        }
        input[type='email']{
            border-radius: 5px 5px 0px 0px;
        }
        input[type='password']{
            border-radius: 0px 0px 5px 5px;
        }
        input[type='email'],input[type='password']{
             padding: 20px 10px;
        }
    </style>
@endsection
