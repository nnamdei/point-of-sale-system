
@extends('layouts.app')

@section('main')

<div class="row" >
    <div class="col-md-6 offset-md-3 col-no-padding-xs">
        <h5>Users</h5>
        @if($users->count() > 0)
        @foreach($users as $user)
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-no-padding-xs">
                            <div class="">
                                <img src="{{$user->avatar()}}" alt="{{$user->fullname()}}" class="avatar" width="70px" height="70px">
                            </div>
                        </div>
                        <div class="col-md-8 col-no-padding-xs">
                            <h5><a href="{{route('users.show',['id' => $user->id])}}">{{$user->fullname()}}</a></h5>
                            <div class="grey">
                                <p><i class="fa fa-user theme-color"></i>  {{$user->position()}}</p>
                                <div class="text-right">
                                    <small>Added {{$user->created_at->diffForHumans()}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @else
        <div class="text-center text-danger">
            <i class="fa fa-exclamation-triangle"></i> No user yet
        </div>
        @endif
    </div>
</div>
   
@endsection

@section('scripts')
    <script src="{{ asset('js/image-preview.js') }}"></script>
@endsection
