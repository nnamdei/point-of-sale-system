
@extends('layouts.appRHSfixed')

@section('main')
   <div class="theme-bg" style="margin-top:20px; padding-top: 100px">
        <div class="white-bg" style="">
            <div class="row">
                <div class="col-3">
                    <img src="{{$user->avatar()}}" alt="{{$user->fullname()}}" class="avatar" style="width: 200px; height: 200px; margin-top: -100px; border-width: 3px ">
                </div>
                <div class="col-9">
                    <h4 class="theme-secondary-color">{{$user->fullname()}}</h4>
                    <div class="grey">
                        <p style="margin: 2px">{{$user->position()}}</p>
                        <small><i class="fa fa-clock"></i> Added {{ $user->created_at->diffForHumans() }}</small>
                        @if(Auth::user()->isManager())
                            <div class="text-right">
                                <a href="{{route('users.edit',['id'=>$user->id])}}"><i class="fa fa-pen"></i>  edit</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
   </div>

    <div class="card">
        <div class="card-header">
            Activities
        </div>
        <div class="card-body" style="padding: 0">
            @if(Auth::user()->isManager())
                @include('transactions.widgets.history')
            @endif
        </div>
    </div>

@endsection

@section('RHS')
<div style="margin-top: 5px">
    <?php
        $users_w_title = "Other Users";
        $users_w = $USERS_->where('id','!=',$user->id)->get();
    ?>
    @include('widgets.users')
</div>
@endsection

@section('styles')

@endsection