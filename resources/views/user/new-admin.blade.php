<form action="{{route('admin.store')}}" method="post">
    @csrf
    <div class="form-group">
        <label for="">First name</label>
        <input type="text" class="form-control" name="first_name" placeholder="admin first name" value="{{old('first_name')}}">
    </div>
    
    <div class="form-group">
        <label for="">Last name</label>
        <input type="text" class="form-control" name="last_name" placeholder="admin last name" value="{{old('last_name')}}">
    </div>

    <div class="form-group">
        <label for="">Email</label>
        <input type="text" class="form-control" name="email" placeholder="enter a valid email address" value="{{old('email')}}">
    </div>

    <div class="form-group">
        <label for="">Create password</label>
        <input type="password" class="form-control" name="password" placeholder="create password of min: 6 characters">
    </div>
    <div class="form-group">
        <label for="">Confirm password</label>
        <input type="password" class="form-control" name="password_confirmation" placeholder="repeat password">
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-block theme-btn">Start</button>
    </div>
</form>