<form  method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

        <div>  
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email"  required autofocus>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <div>
            <input id="password" type="password" class="form-control" name="password" placeholder="password"  required>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="text-center">
            <button type="submit" class="btn theme-btn">
               <i class="fa fa-sign-in-alt"></i>  Login
            </button>
        </div>
    </div>
    <div class="text-right">
        <a class="white" href="{{ route('password.request') }}"> Forgot Your Password?</a>
    </div>
</form>
