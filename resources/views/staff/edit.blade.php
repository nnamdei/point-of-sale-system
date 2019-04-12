@extends('layouts.app')

@section('main')

<div class="row" style="margin-top: 10px">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                Update staff: <span class="theme-color">{{$staff->fullname()}}</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('staff.update',['id'=>$staff->id]) }}" class="has-image-upload" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                <label for="firstname" class="control-label">First Name</label>

                                <div class="">
                                    <input id="firstname" type="text" class="form-control" name="firstname" value="{{$staff->firstname}}" required autofocus>

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
                                    <input id="lastname" type="text" class="form-control" name="lastname" value="{{$staff->lastname}}" required autofocus>

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
                                    <input id="email" type="email" class="form-control" name="email" value="{{$staff->email}}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                                <label for="position" class="control-label">Position</label>

                                <div class="">
                                    <select name="position" id="position" class="form-control">
                                        <option value="staff" {{$staff->position == 'staff' ? 'selected' : ''}}>Regular staff</option>
                                        <option value="attendant" {{$staff->position == 'attendant' ? 'selected' : ''}}>Attendant</option>
                                        <option value="manager" {{$staff->position == 'manager' ? 'selected' : ''}}>Manager</option>
                                    </select>
                                    @if ($errors->has('position'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('position') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> -->

                        </div>
                        <div class="col-sm-4">
                        <div class="text-center">
                                <img id="user-avatar-preview" src="{{$staff->avatar()}}" alt="{{$staff->fullname()}}" width="100%"> 
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
                                        Update staff
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
   
@endsection

@section('scripts')
    <script src="{{ asset('js/image-preview.js') }}"></script>
@endsection
