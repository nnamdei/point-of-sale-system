<form method="POST" action="{{ route('users.update',['id'=>$user->id]) }}" class="has-image-upload" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                <label for="firstname" class="control-label">First Name</label>

                <div class="">
                    <input id="firstname" type="text" class="form-control" name="firstname" value="{{$user->firstname}}" required autofocus>

                    @if ($errors->has('firstname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('firstname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                <label for="lastname" class="control-label">Last Name</label>

                <div class="">
                    <input id="lastname" type="text" class="form-control" name="lastname" value="{{$user->lastname}}" required autofocus>

                    @if ($errors->has('lastname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lastname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="control-label">E-Mail Address</label>

                <div class="">
                    <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                <label for="position" class="control-label">Position</label>

                <div class="">
                    <select name="position" id="position" class="form-control">
                        <option value="0" {{$user->position == 0 ? 'selected' : ''}}>Attendant</option>
                        <option value="1" {{$user->position == 1 ? 'selected' : ''}}>Manager</option>
                    </select>
                    @if ($errors->has('position'))
                        <span class="help-block">
                            <strong>{{ $errors->first('position') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

        </div>
        <div class="col-sm-4">
          <div class="text-center">
                <img id="user-avatar-preview" src="{{$user->avatar()}}" alt="{{$user->fullname()}}" width="100%"> 
          </div>
            <div class="image-preview-container text-center" replace="#user-avatar-preview"></div>
            <div class="form-group">
                <label for="avatar" class="control-label grey">User Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <div class="text-center" >
                    <button type="submit" class="btn btn-success">
                        Update User
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>
