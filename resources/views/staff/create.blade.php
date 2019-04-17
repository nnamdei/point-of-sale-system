
@extends('layouts.appRHSfixed')

@section('main')

<div class="row justify-content-center mt-2">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-header">
                <h6>New staff</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('staff.store') }}" class="has-image-upload" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <h6>Shop: {{Auth::user()->shop->name}}</h6>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                <label for="firstname" class="control-label">First Name</label>

                                <div class="">
                                    <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required autofocus>

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
                                    <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required autofocus>

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
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-4">
                        <div class="text-center">
                                <img id="user-avatar-preview" src="{{asset('storage/images/users/default.png')}}" alt="User Avatar" width="100%"> 
                        </div>
                            <div class="image-preview-container text-center" replace="#user-avatar-preview"></div>
                            <div class="form-group">
                                <label for="avatar" class="control-label grey">Avatar</label>
                                <input type="file" name="avatar" id="avatar">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center" >
                                    <button type="submit" class="btn theme-btn">
                                        Add Staff
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

@section('RHS')
    @include('widgets.staff')
@endsection

@section('scripts')
    <script src="{{ asset('js/image-preview.js') }}"></script>
@endsection
