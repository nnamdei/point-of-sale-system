
@extends('layouts.appRHSfixed')

@section('h-scripts')
    <script type="text/javascript" src="{{asset('js/vendors/fusioncharts/fusioncharts.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/vendors/fusioncharts/fusioncharts.theme.fusion.js')}}"></script>
@endsection

@section('main')
   <div class="theme-bg" style="margin-top:-5px; padding-top: 120px">
        <div class="white-bg" style="">
            <div class="row">
                <div class="col-sm-3 text-center">
                    <img src="{{$user->avatar()}}" alt="{{$user->fullname()}}" class="avatar" style="width: 200px; height: 200px; margin-top: -100px; border-width: 3px ">
                </div>
                <div class="col-sm-9  text-center">
                    <h5 class="theme-secondary-color">{{$user->fullname()}}</h5>
                    <div class="grey">
                        <p style="margin: 2px">{{$user->position()}}</p>
                        <small><i class="fa fa-clock"></i> Added {{ $user->created_at->diffForHumans() }}</small>
                        @if(Auth::user()->isManager())
                        <div class="d-flex py-3">
                            <div class="mr-auto">
                                    <a href="{{route('users.edit',['id'=>$user->id])}}"><i class="fa fa-pen"></i>  edit info</a>
                                </div>
                                @if($user->isAttendant())
                                    <div class="ml-auto">
                                        @if($user->deskClosed())
                                            @include('desk.widgets.open')
                                        @else
                                            @include('desk.widgets.close')
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
   </div>
   @if(Auth::user()->isManager() || Auth::id() == $user->id)
        <div class="card">
            <div class="card-header">
               {{Auth::id() == $user->id ? 'My transactions' : 'Transactions by '.$user->firstname}} 
            </div>
            <div class="card-body" style="padding: 0">
                @include('transactions.widgets.filter')
                @include('transactions.widgets.sales')
                @include('transactions.widgets.activities')
            </div>
        </div>
    @endif
@endsection

@section('RHS')
<div style="margin-top: 5px">
    <?php
        $users_w_title = "Other Users";
        $users_w = $_user::where('id','!=',$user->id)->get();
    ?>
    @include('widgets.users')
</div>
@endsection

